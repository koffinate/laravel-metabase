<?php

namespace Koffinate\Metabase;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MetabaseComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  int|null  $dashboard
     * @param  int|null  $question
     * @param  array<string>  $params
     * @param  bool  $bordered
     * @param  bool  $titled
     * @param  string|null  $theme
     */
    public function __construct(
        protected readonly int|null $dashboard = null,
        protected readonly int|null $question = null,
        protected readonly array $params = [],
        protected readonly bool $bordered = false,
        protected readonly bool $titled = false,
        protected readonly string|null $theme = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        if (config('koffinate.metabase.off')) {
            return view('metabase::off', [
                'message' => config('koffinate.metabase.off_message', 'metabase was disabled')
            ]);
        }
        
        if (! config('koffinate.metabase.on_local') && app()->isLocal()) {
            return view('metabase::off');
        }

        $metabase = app(MetabaseService::class)
            ->setParams($this->params)
            ->setAdditionalParams($this->getAdditionalParams());

        try {
            $iframeUrl = $metabase->generateEmbedUrl((int) $this->dashboard, (int) $this->question);
        } catch (\Exception $e) {
            if (! config('app.debug')) {
                return view('metabase::off', ['message' => $e->getMessage()]);
            }
            throw $e;
        }

        return view('metabase::iframe', compact('iframeUrl'));
    }

    /** @internal */
    private function getAdditionalParams(): array
    {
        $additionalParameters = [
            'bordered' => $this->bordered,
            'titled' => $this->titled,
        ];

        if ($this->theme) {
            $additionalParameters['theme'] = $this->theme;
        }

        return $additionalParameters;
    }
}
