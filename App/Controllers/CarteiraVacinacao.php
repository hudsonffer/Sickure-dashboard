<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paciente
 *
 * @author Aluno
 */
class CarteiraVacinacao extends Generic
{
    
    
    function __construct()
    {
        parent::__construct();
        $this->tablename = "CarteiraVacinacao";
        $this->pkey = "null";
        $this->ativokey = "null";
        $this->searchkey = "null";
    }
    
    
    function searchPorPaciente($paciente_id)
    {
        $mypdo = new MyPDO();
        $stmt = $mypdo->run("SELECT * FROM ".$this->tablename." NATURAL JOIN Vacina NATURAL JOIN Funcionario WHERE paciente_id=? ORDER BY vacina_id, cvac_data DESC",[$paciente_id])->fetchAll();
        return $stmt;
    }

    function searchPorPeriodo($tipo, $inicio, $fim)
    {
        $mypdo = new MyPDO();
        $stmt = $mypdo->run("SELECT * FROM ".$this->tablename." NATURAL JOIN Vacina NATURAL JOIN Funcionario NATURAL JOIN Paciente WHERE cvac_tipo=? AND (cvac_data BETWEEN ? AND ?) ORDER BY cvac_data",[$tipo, $inicio, $fim])->fetchAll();
        return $stmt;
    }
    
    function searchPorFuncionario($funcionario_id)
    {
        $mypdo = new MyPDO();
        $stmt = $mypdo->run("SELECT * FROM ".$this->tablename." WHERE funcionario_id=?",[$funcionario_id])->fetchAll();
        return $stmt;
    }
    
    function searchPorVacina($vacina_id)
    {
        $mypdo = new MyPDO();
        $stmt = $mypdo->run("SELECT * FROM ".$this->tablename." WHERE vacina_id=?",[$vacina_id])->fetchAll();
        return $stmt;
    }
    
    function searchPorLoteVacina($vacina_id, $vlote_codigo)
    {
        $mypdo = new MyPDO();
        $stmt = $mypdo->run("SELECT * FROM ".$this->tablename." WHERE vacina_id=? AND vlote_codigo=?",[$vacina_id,$vlote_codigo])->fetchAll();
        return $stmt;
    }
    
    function updateCarteira($paciente_id, $vacina_id, $cvac_data, $dados)
    {
        $mypdo = new MyPDO();
        
        $pairs = [];
        $values = [];
        foreach($dados as $key => $value)
        {
            $pairs[] = $key."=?";
            $values[] = $value;
        }
        $sql = "UPDATE ".$this->tablename." SET ".implode(",",$pairs)." WHERE paciente_id=? AND vacina_id=? AND cvac_data=?";
        $values[] = $paciente_id;
        $values[] = $vacina_id;
        $values[] = $cvac_data;
        $stmt = $mypdo->run($sql,$values);
        return $stmt->rowCount();
    }
    
    function deleteCarteira($paciente_id, $vacina_id, $cvac_data)
    {
        $mypdo = new MyPDO();
        $stmt = $mypdo->run("DELETE FROM ".$this->tablename." WHERE paciente_id=? AND vacina_id=? AND cvac_data=?",[$paciente_id, $vacina_id, $cvac_data]);
        return $stmt->rowCount();
    }
}