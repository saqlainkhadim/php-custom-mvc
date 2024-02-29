<?php


namespace app\core\form;


use app\core\Model;

class Field
{
    private Model $model;
    private string $attribute;
    private string $type = 'text';

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label class="text-capitalize">%s</label>
                <input type="%s" name="%s" value="%s" class="form-control %s" \>
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            str_replace('_',' ',$this->attribute),
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute} ?? "",
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->model->getFirstError($this->attribute),

        );
    }

    public function passwordField()
    {
        $this->type = 'password';
        return $this;
    }

    public function emailField()
    {
        $this->type = 'email';
        return $this;
    }

}