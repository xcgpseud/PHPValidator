<?php

namespace Validator;

class Validator
{
    /**
     * @var Validation[]
     */
    private $validations = [];

    /**
     * @return Validation
     */
    public function add()
    {
        $v = new Validation($this);
        array_push($this->validations, $v);
        return $v;
    }

    /**
     * @return \Closure
     */
    public function getFunction()
    {
        $function = function ($target) {
            $validated = true;
            foreach ($this->validations as $validation) {
                if (!isset($target) || empty($validation->getActions())) {
                    return false;
                }
                if (is_array($target)) {
                    if (empty($validation->getKeys())) {
                        foreach ($validation->getActions() as $action) {
                            if (!$action($target)) {
                                $validated = false;
                                break;
                            }
                        }
                    }
                    if (!is_array($validation->getKeys())) {
                        $validation->withKeys([$validation->getKeys()]);
                    }
                    foreach ($validation->getActions() as $action) {
                        foreach ($validation->getKeys() as $key) {
                            if (
                                array_key_exists($key, $target) &&
                                !$action($target[$key])
                            ) {
                                $validated = false;
                                break;
                            }
                        }
                    }
                }
            }
            return $validated;
        };
        return $function;
    }
}

class Validation
{
    /**
     * @var mixed
     */
//    private $target;

    /**
     * @var array
     */
    private $keys = [];
    private $actions = [];

    /**
     * @var Validator
     */
    private $parentValidator;

    /**
     * Validation constructor.
     * @param $validator
     */
    public function __construct($validator)
    {
        $this->parentValidator = $validator;
    }

    // TODO: Add "All Keys" functionality

    /**
     * @param $key
     * @return $this
     */
    public function withKey($key)
    {
        array_push($this->keys, $key);
        return $this;
    }

    /**
     * @param $keys
     * @return $this
     */
    public function withKeys($keys)
    {
        if (empty($this->keys)) {
            $this->keys = $keys;
        } else {
            $this->keys = array_merge($this->keys, $keys);
        }
        return $this;
    }

    /**
     * @param $action
     * @return $this
     */
    public function withAction($action)
    {
        array_push($this->actions, $action);
        return $this;
    }

    /**
     * @return Validator
     */
    public function save()
    {
        return $this->parentValidator;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }
}