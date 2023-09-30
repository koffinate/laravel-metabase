<?php

namespace Koffinate\Metabase;

use InvalidArgumentException;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class MetabaseService
{
    /** @var array<string> @params */
    private array $params;

    /** @var array<string> @params */
    private array $additionalParams;

    /** @var string @params */
    private string $type = 'dashboard';

    /**
     * @param  array<string>  $params
     *
     * @return \Koffinate\Metabase\MetabaseService
     */
    public function setParams(array $params): static
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param  array  $params
     *
     * @return \Koffinate\Metabase\MetabaseService
     */
    public function setAdditionalParams(array $params): static
    {
        $this->additionalParams = $params;

        return $this;
    }

    /**
     * @param int|null $dashboard
     * @param int|null $question
     *
     * @return string
     */
    public function generateEmbedUrl(?int $dashboard, ?int $question): string
    {
        $metabaseUrl = str(config('koffinate.metabase.url'))->replaceMatches('/[\/\s]+$/', '')->toString();
        $metabaseSecret = config('koffinate.metabase.secret');

        if (! $metabaseUrl && ! $metabaseSecret) {
            throw new InvalidArgumentException('Metabase URL and Secret not yet set');
        }

        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($metabaseSecret)
        );

        $builder = $config->builder();

        if (! $dashboard && ! $question) {
            throw new InvalidArgumentException('Dashboard or question must be specified');
        }

        $claimParam = ['dashboard' => $dashboard];
        if ($question) {
            $claimParam = ['question' => $question];
            $this->type = 'question';
        }
        $builder->withClaim('resource', $claimParam);

        $params = $this->params;
        if (empty($params)) {
            $params = (object) $params;
        }
        $builder->withClaim('params', $params);

        $token = $builder->getToken($config->signer(), $config->signingKey())->toString();

        return sprintf(
            '%s/embed/%s/%s#'.http_build_query($this->additionalParams),
            $metabaseUrl,
            $this->type,
            $token
        );
    }
}
