<?php
namespace App\Models\Entities;
use App\Core\baseEntity;
use App\Models\Entities\Autor;
use App\Models\Entities\Ejemplar;

class Libro extends baseEntity{
    private ?int $id;
    private string $titulo;
    private array $autores = [];
    private ?int $idEditorial;
    private ?string $idArea;
    private string $cota;
    private ?string $isbn;
    private ?int $paginas;
    private ?string $volume;
    private ?string $observaciones;
    private ?int $anioPublicacion;
    private bool $activo;
    private array $ejemplares = [];

    public function __construct(
        ?int $id,
        string $titulo,
        ?int $idEditorial = null,
        ?string $idArea = null,
        string $cota = '',
        ?string $isbn = null,
        ?int $paginas = null,
        ?string $observaciones = null,
        ?int $anioPublicacion = null,
        bool $activo = true,
        ?string $volume = null
    ) {
        $this->id = $id;
        $this->setTitulo($titulo);
        $this->idEditorial = $idEditorial;
        $this->idArea = $idArea;
        $this->cota = $cota;
        $this->isbn = $isbn;
        $this->paginas = $paginas;
        $this->observaciones = $observaciones;
        $this->anioPublicacion = $anioPublicacion;
        $this->activo = $activo;
        $this->volume = $volume;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getCota(): string { return $this->cota; }
    public function getTitulo(): string { return $this->titulo; }
    public function getAutores(): array { return $this->autores; }
    public function getIsbn(): ?string { return $this->isbn; }
    public function isActivo(): bool { return $this->activo; }
    public function getIdEditorial(): ?int { return $this->idEditorial; }
    public function getIdArea(): ?string { return $this->idArea; }
    public function getPaginas(): ?int { return $this->paginas; }
    public function getVolume(): ?string { return $this->volume; }
    public function getObservaciones(): ?string { return $this->observaciones; }
    public function getAnioPublicacion(): ?int { return $this->anioPublicacion; }
    public function getEjemplares(): array { return $this->ejemplares; }


    // Setters
    public function setTitulo(string $titulo): void {
        $titulo = trim($titulo);
        if ($titulo === '') throw new \InvalidArgumentException('El título no puede estar vacío');
        $this->titulo = $titulo;
    }

    public function setAutores(array $autores): void {
        foreach ($autores as $autor) {
            if (!($autor instanceof Autor)) {
                throw new \InvalidArgumentException("Todos los elementos deben ser instancias de Autor");
            }
        }
        $this->autores = $autores;
    }

    public function setEjemplares(array $ejemplares): void {
        foreach ($ejemplares as $ejemplar) {
            if (!($ejemplar instanceof Ejemplar)) {
                throw new \InvalidArgumentException("Todos deben ser instancias de Ejemplar");
            }
        }
        $this->ejemplares = $ejemplares;
    }

    public function addEjemplar(Ejemplar $ejemplar): void {
        $this->ejemplares[] = $ejemplar;
    }



    public function setIsbn(?string $isbn): void {
        $this->isbn = $isbn !== null ? trim($isbn) : null;
    }


    // Creación de una entidad Libro a partir de un array
    public static function fromArray(array $row): self {
        return new self(
            isset($row['ID_Libro']) ? (int)$row['ID_Libro'] : null,
            $row['Titulo'] ?? '',
            isset($row['ID_Editorial']) ? (int)$row['ID_Editorial'] : null,
            $row['ID_Area'] ?? null,
            $row['Cota'] ?? '',
            $row['ISBN'] ?? null,
            isset($row['Paginas']) ? (int)$row['Paginas'] : null,
            $row['Observaciones'] ?? null,
            isset($row['Anio_Publicacion']) ? (int)$row['Anio_Publicacion'] : null,
            isset($row['Activo']) ? (bool)$row['Activo'] : true
        );
    }
}