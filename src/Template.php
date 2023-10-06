<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace losthost\templateHelper;

/**
 * Description of newPHPClass
 *
 * @author drweb
 */
class Template {
    
    protected $language_code;
    protected $template_dir = 'templates';
    protected $template_file;
    protected $__data = [];
    
    public function __construct($template_file, $language_code=null) {
        $this->template_file = $template_file;
        $this->language_code = $language_code;
    }
    
    public function assign($name, $value) {
        $this->__data[$name] = $value;
    }
    
    public function display() {
        $template = $this->getTemplatePath();
        
        foreach ($this->__data as $key => $value) {
            ${$key} = $value;
        }

        include $template;
    }
    
    public function process() {
        $template = $this->getTemplatePath();
        
        ob_start();
        $this->display();
        return ob_get_clean();
    }
    public function setTemplateDir($dir) {
        $this->template_dir = $dir;
    }
    
    protected function getTemplatePath() {
        if (empty($this->language_code)) {
            $lang = 'default';
        } else {
            $lang = $this->language_code;
            if (!is_dir("$this->template_dir/$lang")) {
                $lang = 'default';
            }
        }
        
        $path = "$this->template_dir/$lang/$this->template_file";
        if (!file_exists($path)) {
            throw new \Exception("Template file does not exist: $path", -10007);
        }
        
        return $path;
    }
    
    
}
