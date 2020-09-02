<?php


namespace App\Model\ResidenciaMultiprofissional;


use App\Serializers\OfertaModuloTurmasSupervisorSerializer;

class OfertaModulo extends BaseModelSagu
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var date
     */
    public $dataInicio;

    /**
     * @var \DateTime
     */
    public $dataFim;

    /**
     * @var string
     */
    public $encerramento;

    /**
     * @var string
     */
    public $nome;

    /**
     * @var int
     */
    public $semestre;

    /**
     * @var String
     */
    public $semestre_descricao;

    /**
     * @var Turma
     */
    public $turma;

    /**
     * @var Modulo
     */
    public $modulo;

    protected $mapFieldModel = [
        'ofertadeunidadetematicaid' => 'id',
        'inicio' => 'dataInicio',
        'fim' => 'dataFim'
    ];

    /**
     * OfertaModulo constructor.
     * @param int $ofertadeunidadetematicaid
     * @param date $inicio
     * @param date $fim
     * @param string $encerramento
     * @param string $nome
     * @param int $semestre
     * @param String $semestre_descricao
     */
    public function __construct($dados = null)
    {
        if (!$dados) {
            return;
        }

        parent::__construct($dados);
    }

    function popularModelo($dados)
    {
        $turma = [];
        $modulo = [];
        foreach ($dados as $key => $value) {
            if (strpos($key, 'turma.') !== false) {
                $joinTurma = explode('.', $key);
                $turma[$joinTurma[1]] = $value;
                continue;
            }

            if (strpos($key, 'modulo.') !== false) {
                $joinModelo = explode('.', $key);
                $modulo[$joinModelo[1]] = $value;
                continue;
            }

            $this->$key = $value;
        }

        $this->turma = new Turma($turma);
        $this->modulo = new Modulo($modulo);

        return $this;
    }
}