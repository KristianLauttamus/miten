<?php

namespace App\Models;

use ArrayAccess;
use Exception;
//use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class BaseModel implements ArrayAccess
{
    // PrimaryKey
    protected $primaryKey = 'id';

    // Dates
    protected $dates = ['created_at', 'updated_at'];

    // Fillable attributes
    protected $fillable = [];

    // Attributes
    protected $attributes;

    /**
     * The array of booted models.
     *
     * @var array
     */
    protected static $booted = [];

    public function __construct(array $attributes = [])
    {
        $this->checkExists();
        $this->fill($attributes);
    }

    private function checkExists()
    {
        if (isset($this->attributes[$this->primaryKey])) {
            return $this->find($this->attributes[$this->primaryKey]) ? true : false;
        }

        return false;
    }

    /**
     * Get Model's table as a String
     * @return String
     */
    private function getTable()
    {
        if (isset($this->table)) {
            return $this->table;
        }

        return str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
    }

    public static function find($pKey)
    {
        return DB::select('select * from ' . static::getTable() . ' where ' . $this->primaryKey . ' = ' . $pkey);
    }

    public static function all()
    {
        $instance = new static;

        return DB::select('select * from ' . $instance->getTable());
    }

    public static function where($column, $operator, $value)
    {
        $instance = new static;

        return DB::select('select * from ' . $instance->getTable() . ' where ' . $column . ' ' . $operator . ' ' . $value);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {

        if ($user = User::getUserLoggedIn()) {
            $attributes['user_id'] = $user->id;
        }

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

    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Save the model
     */
    public function save(array $newAttributes = null)
    {
        $queryAttr = implode(', ', array_keys($this->attributes));
        $queryVals = implode(', ', $this->attributes);
        $query = 'INSERT INTO ' . static::getTable() . '(' . $queryAttr . ') VALUES (' . $queryVals . ')';

        $db = DB::insert($query);
        dd($query);
    }

    /**
     *
     */
    public function checkAttributes(array $attributes)
    {
        $returnable = [];
        dd($this->fillable);
        foreach ($this->fillable as $fillable) {
            isset($attributes[$fillable]) ? $returnable[$fillable] = $attributes[$fillable] : '';
        }

        return $returnable;
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static;

        return call_user_func_array([$instance, $method], $parameters);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return (isset($this->attributes[$key]) || isset($this->relations[$key])) ||
            ($this->hasGetMutator($key) && !is_null($this->getAttributeValue($key)));
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key], $this->relations[$key]);
    }
}
