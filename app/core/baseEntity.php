<?php 
namespace App\Core;
abstract class baseEntity {  
    public function toArray(): array {
        $data = [];
        // Usamos Reflection para poder "ver" propiedades protegidas de la clase hija
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            // Esto le da permiso temporal a baseEntity para leer la propiedad del hijo
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($this);
        }
        return $data;
    }

    public static function fromArray(array $data): static {
        $entity = new static();
        foreach ($data as $key => $value) {
            // Normalizamos la clave: "ID_Editorial" o "id_editorial" -> "IdEditorial"
            $normalizedKey = str_replace(['_', ' '], '', ucwords(strtolower($key), '_ '));
            $method = 'set' . $normalizedKey;

            if (method_exists($entity, $method)) {
                $entity->$method($value);
            } else {
                // Si no hay setter, intentamos asignar a la propiedad (ej: $titulo)
                $prop = lcfirst($normalizedKey);
                if (property_exists($entity, $prop)) {
                    $reflection = new \ReflectionProperty($entity, $prop);
                    $reflection->setAccessible(true);
                    $reflection->setValue($entity, $value);
                }
            }
        }
        return $entity;
    }
}
?>