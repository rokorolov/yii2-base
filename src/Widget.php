<?php

/**
 * @copyright Copyright (c) Roman Korolov, 2015
 * @link https://github.com/rokorolov/yii2-base
 * @license http://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 */

namespace rokorolov\base;

use yii\helpers\Json;
use yii\web\JsExpression;
use yii\base\Widget as BaseWidget;

/**
 * Base widget class for rokorolov extensions
 *
 * @author Roman Korolov <rokorolov@gmail.com>
 */
class Widget extends BaseWidget
{
    use \rokorolov\base\TranslationTrait;
        
    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];
    
    /**
     * @var array widget plugin options 
     */
    public $pluginOptions = [];
    
    /**
     * @var array the the internalization configuration for this widget
     */
    public $i18n = [];
    
    /**
     * @var string translation message file category name for i18n
     */
    protected $_messageCategory = '';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }
    
    /**
     * Encodes the given options array into a JSON string.
     * 
     * @return string
     */
    public function getEncodedPluginOptions()
    {
        $options = [];

        foreach ($this->pluginOptions as $key => $value) {
            $options[$key] = $this->encode($value);
        }

        return Json::encode($options);
    }

    /**
     * Prepare array options to encode into a json string.
     * 
     * @param array $value
     * @return array
     */
    protected function encode($value)
    {
        if (is_bool($value)) {
            return new JsExpression(($value ? 'true' : 'false'));
        } elseif (is_array($value)) {
            $parsed = [];
            foreach ($value as $child) {
                $parsed[] = self::encode($child);
            }
            return $parsed;
        }
        return $value;
    }
}
