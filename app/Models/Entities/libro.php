<?php
namespace App\Models\Entities;
use App\Core\baseEntity;
use App\Models\Entities\Autor;
use App\Models\Entities\Ejemplar;

class Libro extends baseEntity{
    private ?int $id;
    private string $titulo;
    private array $autores = [];
    private ?string $idSala;
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
        ?int $id = null,
        string $titulo = '',
        ?int $idEditorial = null,
        ?string $idSala = null,
        ?string $idArea = null,
        string $cota = '',
        ?string $isbn = null,
        ?int $paginas = 0,
        ?string $observaciones = null,
        $anio = null,
        bool $activo = true,
        ?string $volumen = null
    ) {
        $this->id = $id;
        if ($titulo !== '') {
            $this->setTitulo($titulo);
        } else {
            $this->titulo = '';
        }
        $this->idEditorial = $idEditorial;
        $this->idSala = $idSala;
        if ($this->idSala === 'X') {
            $this->idArea = $idArea;
        } else {
            $this->idArea = $this->extraerAreaDeCota($cota);
        }
        $this->cota = $cota;
        $this->isbn = $isbn;
        $this->setPaginas($paginas);
        $this->observaciones = $observaciones;
        $this->setAnioPublicacion($anio);
        $this->activo = $activo;
        $this->volume = $volumen;
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

    public function setCota(string $cota): void {
    $this->cota = trim($cota);
    
    // Si no es sala infantil (X), extraemos el área automáticamente
        if ($this->idSala !== 'X' && !empty($this->cota)) {
            $this->idArea = $this->extraerAreaDeCota($this->cota);
        }
    }

    private function extraerAreaDeCota(string $cota): string {
        // Buscamos el primer separador (punto o espacio)
        $pos = strpos($cota, '.') ?: strpos($cota, ' ');
        
        if ($pos === false) return $cota; // Si no hay separador, la cota misma es el código

        $codigo = substr($cota, 0, $pos);

        // Lógica Dewey: Si empieza por número, el área suele ser la centena (ej: 823 -> 820)
        if (is_numeric($codigo[0]) && strlen($codigo) >= 3) {
            // Transformamos el último dígito en 0 para normalizar el área
            $codigo[strlen($codigo) - 1] = '0';
        }

        return $codigo;
    }

    public function setIdSala(string $idSala): void {
        $this->idSala = $idSala;
        // Si cambiamos a una sala que no es X, recalculamos el área por si ya hay cota
        if ($idSala !== 'X' && !empty($this->cota)) {
            $this->idArea = $this->extraerAreaDeCota($this->cota);
        }
    }

    public function setTitulo(?string $titulo): void {
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

    public function setPaginas($paginas): void {
        $this->paginas = (int) $paginas;
    }

    public function setAnioPublicacion($anio): void {
        if (empty($anio)) {
            $this->anioPublicacion = null;
        } else {
            $this->anioPublicacion = (int) $anio;
        }
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
    /*public static function fromArray(array $row): self {
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
    }*/
}