<?php
namespace App\Entities;

class Libro {
    private ?int $id;
    private string $titulo;
    private ?int $idEditorial;
    private ?string $idArea;
    private string $cota;
    private ?string $isbn;
    private ?int $paginas;
    private ?string $observaciones;
    private ?int $anioPublicacion;
    private bool $activo;

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
        bool $activo = true
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
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getTitulo(): string { return $this->titulo; }
    public function getIsbn(): ?string { return $this->isbn; }
    public function isActivo(): bool { return $this->activo; }
    public function getIdEditorial(): ?int { return $this->idEditorial; }
    public function getIdArea(): ?string { return $this->idArea; }
    public function getCota(): string { return $this->cota; }
    public function getPaginas(): ?int { return $this->paginas; }
    public function getObservaciones(): ?string { return $this->observaciones; }
    public function getAnioPublicacion(): ?int { return $this->anioPublicacion; }

    // Setters con validaciones simples
    public function setTitulo(string $titulo): void {
        $titulo = trim($titulo);
        if ($titulo === '') throw new \InvalidArgumentException('El título no puede estar vacío');
        $this->titulo = $titulo;
    }

    public function setIsbn(?string $isbn): void {
        $this->isbn = $isbn !== null ? trim($isbn) : null;
    }

    // Serialización/normalización para persistencia
    public function toArray(): array {
        return [
            'ID_Libro' => $this->id,
            'Titulo' => $this->titulo,
            'ID_Editorial' => $this->idEditorial,
            'ID_Area' => $this->idArea,
            'Cota' => $this->cota,
            'ISBN' => $this->isbn,
            'Paginas' => $this->paginas,
            'Observaciones' => $this->observaciones,
            'Anio_Publicacion' => $this->anioPublicacion,
            'Activo' => $this->activo ? 1 : 0,
        ];
    }

    // Factory desde array (útil al leer DB)
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