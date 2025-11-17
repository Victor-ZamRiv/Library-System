<?php 
namespace App\Core;
abstract class baseEntity{
    public function toArray(): array{
        $vars = get_object_vars($this);
        $data = [];
        foreach ($vars as $key => $value) {
            $prop = ltrim($key, "\0*\0");
            $data[$prop] = $value;
        }
        return $data;
    }

    public static function fromArray(array $data): static{
        $entity = new static();
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            } elseif (property_exists($entity, $key)) {
                $entity->$key = $value;
            }
        }
        return $entity;
    }
}
?>