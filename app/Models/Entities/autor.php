<?php
    namespace App\Models\Entities;
    use App\Core\baseEntity;

    class Autor extends baseEntity{
        private ?int $id;
        private string $nombre;

        public function __construct(?int $id = null, string $nombre = ''){
            $this->id = $id;
            $this->nombre = $nombre;
        }

        public function setIdAutor(?int $id): void {
            $this->id = $id;
        }

        public function getId(): ?int {
            return $this->id;
        }

        public function getNombre(): string {
            return $this->nombre;
        }

        public function setNombre(string $nombre): void {
            $this->nombre = $nombre;
        }


    }

?>