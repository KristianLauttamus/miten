<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use DateTime;
use Exception;
use ArrayAccess;
use Carbon\Carbon;
use LogicException;
use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model;

class Model Extends Model {
    // PrimaryKey
    protected $primaryKey = 'id';

    // Dates
    protected $dates = ['created_at', 'updated_at'];

    // Fillable attributes
    protected $fillable;

    // Attributes
    protected $attributes;

    public function __construct(array $attributes = null) {
        $this->checkExists();
        $this->fill($attributes);
    }

    public function __get($key){
        return $this->attributes[$key];
    }

    public function __set($key, $value){
        return $this->attributes[$key] = $value;
    }

    private function checkExists()
    {
        if(isset($this->attributes[$this->primaryKey])){
            $this = $this->find($this->attributes[$this->primaryKey]);
        }
    }

    /**
     * Get Model's table as a String
     * @return String
     */
    private function getTable(){
        if (isset($this->table)) {
            return $this->table;
        }

        return str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
    }

    public static function find($pKey){
        return DB::select('select * from ' . static::getTable() . ' where ' . $this->primaryKey . ' = ' . $pkey);
    }

    public static function all(){
        $instance = new static;

        return DB::select('select * from ' . $instance->getTable());
    }

    public static function where($column, $operator, $value){
        return DB::select('select * from ' . $instance->getTable() . ' where ' . $column . ' ' . $operator .  ' ' . $value);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $model = new static($attributes);

        $model->save();

        return $model;
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes)
    {
        $attributes = $this->checkAttributes($attributes);

        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }

        return $this;
    }

    /**
     * Save the model
     */
    public function save(array $newAttributes = null)
    {
        $query = 'INSERT INTO ' . static::getTable();
    }

    /**
     *
     */
    public function checkAttributes(array $attributes)
    {
        $returnable = [];
        foreach($this->fillable as $fillable){
            isset($attributes[$fillable]) ? $returnable[$fillable] = $attributes[$fillable] : '';
        }

        return $returnable;
    }
}
