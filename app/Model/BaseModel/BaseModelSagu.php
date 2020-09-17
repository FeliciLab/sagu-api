<?php


namespace App\Model\BaseModel;


abstract class BaseModelSagu
{
    /**
     * @var string Schema do modelo
     */
    protected $schema = '';

    /**
     * @var string nome da tabela dentro do schema
     */
    protected $table = '';

    /**
     * Mapeamento de valores do banco para variáveis internas oa modelo.
     * Criado para dar melhor legibilidade ao código.
     * @var array [ 'coluna do banco' => 'variável do modelo' ]
     */
    protected $mapFieldModel = [];

    /**
     * OBRIGATÓRIO criar uma função SET para o campo composto
     *
     * Variável que vai definir o campo do objeto que será uma composição de outra classe.
     * Utilizado quando fazemos joins e queremos que o objeto esteja agregado ao objeto principal
     *
     * @var array [ 'nome da variável local que representa a composição' => [ array de campos do objeto composto ] ]
     */
    protected $camposComposicao = [];

    /**
     * BaseModelSagu constructor.
     */
    public function __construct($dados = null)
    {
        if (!$dados) {
            return $this;
        }

        $this->popularModelo($dados);
    }


    public function getTable()
    {
        return $this->schema . '.' . $this->table;
    }

    /**
     * @param $dbColumn string
     * @return string
     */
    public function getFieldModel($dbColumn)
    {
        if (isset($this->mapFieldModel[$dbColumn])) {
            return $this->mapFieldModel[$dbColumn];
        }

        return $dbColumn;
    }

    public function defineMethodSetName($localVariable)
    {
        return 'set' . ucfirst($localVariable);
    }

    public function functionSetExists($localVariable)
    {
        return method_exists($this, $this->defineMethodSetName($localVariable));
    }

    public function popularCamposComposicoes()
    {
        foreach ($this->camposComposicao as $key => $value) {
            call_user_func([$this, $this->defineMethodSetName($key)], $value);
        }
    }

    public function mapearCamposComposicao($columnSelect, $dado)
    {
        $columnName = explode('.', $columnSelect);
        $modelVariable = $this->getFieldModel($columnName[0]);
        if (isset($this->camposComposicao[$modelVariable])) {
            $this->camposComposicao[$modelVariable][$columnName[1]] = $dado;
            return true;
        }

        return false;
    }

    function popularModelo($dados)
    {
        foreach ($dados as $key => $value) {
            if ($this->mapearCamposComposicao($key, $value)) {
                continue;
            };

            $modelVariable = $this->getFieldModel($key);

            if ($this->functionSetExists($modelVariable)) {
                call_user_func([$this, $this->defineMethodSetName($modelVariable)], $value);
                continue;
            }

            $this->$modelVariable = $value;
        }


        $this->popularCamposComposicoes();
        return $this;
    }

    /**
     * @return array
     */
    public function getCamposComposicao()
    {
        return $this->camposComposicao;
    }


}