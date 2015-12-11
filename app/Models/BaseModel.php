<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BaseModel
{
    // PrimaryKey
    protected $primaryKey = 'id';

    // Dates
    protected $dates = ['created_at', 'updated_at'];

    // Fillable attributes
    protected $fillable;

    // Attributes
    protected $attributes;

    public function __construct(array $attributes = [])
    {
        $this->checkExists();
        $this->fill($attributes);
    }

    public function __get($key)
    {
        return $this->attributes[$key];
    }

    public function __set($key, $value)
    {
        return $this->attributes[$key] = $value;
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
        dd($this->getFillable());
        foreach ($this->fillable as $fillable) {
            isset($attributes[$fillable]) ? $returnable[$fillable] = $attributes[$fillable] : '';
        }

        return $returnable;
    }
}
