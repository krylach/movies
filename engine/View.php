<?php

namespace Engine;

class View extends \Smarty
{
    private string $template;
    private $config;

    public function __construct(string $template = null)
    {
        $this->config = config('view');

        parent::__construct();

        if ($template) {
            $this->setTemplate($template);
        }

        $this->debugging = $this->config->debugging;
        $this->setTemplateDir($this->config->template_dir);
        $this->setCacheDir($this->config->cache_dir);
        $this->setCompileDir($this->config->compile_dir);
        $this->setConfigDir($this->config->config_dir);

        if ($this->config->cache) {
            $this->setCacheLifetime($this->config->cache->life_time);
            $this->setCaching($this->config->cache->enable);
        }

        if ($this->config->minify) {
            $this->registerFilter("output", function($tpl_output, \Smarty_Internal_Template $template) {
                $tpl_output = preg_replace('![\t ]*[\r\n]+[\t ]*!', '', $tpl_output);
                return $tpl_output;
            });
        }
    }

    public static function flushCache($template = null)
    {
        $self = new static;
        
        if ($template) {
            $template = $self->replaceTemplateName($template);
            $self->clearCache("views/{$template}.{$self->config->suffix_template}.tpl");
        } else {
            $self->clearAllCache();
        }
    }

    public function multipleAssign(array $data)
    {
        foreach ($data as $key => $value) {
            $this->assign($key, $value);
        }

        return $this;
    }

    public function replaceTemplateName(string $template)
    {
        $templateSegments = explode('.', $template);

        return implode('/', $templateSegments);
    }

    public function setTemplate(string $template)
    {
        $this->template = $this->replaceTemplateName($template);

        return $this;
    }

    public function getTemplate()
    {
        return resources_path("views/{$this->template}.{$this->config->suffix_template}.tpl");
    }

    public function render()
    {
        $this->multipleAssign([
            'template_dir' => $this->config->template_dir,
            'suffix_template' => $this->config->suffix_template,
        ]);
        
        $view = $this->display(
            $this->getTemplate()
        );

        return '';
    }
}
