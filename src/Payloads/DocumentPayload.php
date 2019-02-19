<?php

namespace ScoutElastic\Payloads;

use Exception;
use Illuminate\Database\Eloquent\Model;

class DocumentPayload extends TypePayload
{
    /**
     * @param Model $model
     * @throws Exception
     */
    public function __construct(Model $model)
    {
        if ($model->getKey() === null) {
            throw new Exception(sprintf(
                'The key value must be set to construct a payload for the %s instance.',
                get_class($model)
            ));
        }

        parent::__construct($model);
        
        $this->payload['id'] = $model->getKey();
        $this->protectedKeys[] = 'id';

        if (method_exists($model, 'searchableParent')) {
            $this->protectedKeys[] = 'parent';
            $this->payload['parent'] = $model->searchableParent();
        }

        if (method_exists($model, 'searchableRouting')) {
            $this->protectedKeys[] = 'routing';
            $this->payload['routing'] = $model->searchableRouting();
        }
    }
}
