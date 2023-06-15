<?php
/**
 * 
 * Modelo Model_siuxproy
 * @uses Zend_Db_Table
 * @package customs
 */
class Model_siuxproy extends Zend_Db_Table {
    protected $_name = 'impo1106';
    protected $_primary = array('docidxxx', 'subid2xx');
    protected $_reldav = 'impo1107';
    protected $_relite = 'impo1104';
    protected $_reldoi = 'impo1100';
    protected $_reldes = 'impo0101';
    protected $_relpai = 'impo0010';
    protected $_relusr = '';
    protected $_default = '';
    public function init() {
        $cDb = Zend_Registry::get("cDefaultDb");
        $this->_relusr = $cDb . ".sys00010";
        $this->_default = filter_input(INPUT_COOKIE, 'kDbExterna', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Db_Table_Abstract::_setupDatabaseAdapter()
     */
    protected function _setupDatabaseAdapter() {
        $this->_db = Zend_registry::get(filter_input(INPUT_COOKIE, 'kDbExterna', FILTER_SANITIZE_SPECIAL_CHARS));
        parent::_setupDatabaseAdapter();
    }
    /**
     * Traer Todos los datos para el Grid
     * @param string pDt     - Documento de Transporte
     * @return cursor 
     */
    public function fnGenerarKN($pDtr, $pPry, $pLug, $pBlm, $pDro, $pDoc) {
        include 'utility.php';
        $oUti = new utility();
        $qSelect = $this->_db->select()
            ->from("{$this->_default}.{$this->_name}")
            ->where("doidtxxx=?", "{$pDtr}");
        if ($pDoc != '') {
            $qSelect->where('docidxxx=?', "{$pDoc}");
        }
        $qSelect->order(array('regfmodx DESC', 'reghmodx DESC'));
        $xD1 = $this->_db->fetchAll($qSelect);
        if ($xD1 == null && $pDoc != '') {
            $qSelect = $this->_db->select()
                ->from("{$this->_default}.{$this->_name}")
                ->where('docidxxx=?', "{$pDoc}")
                ->where("doidtxxx=?", "")
                ->where('tdeidxxx=?', "3");
            $xD1 = $this->_db->fetchAll($qSelect);
        }
        $dos = $pDtr . " C.TXT";
        $dos2 = $pDtr . " D.TXT";
        $cRoot = $_SERVER['DOCUMENT_ROOT'] . '/downloads/';
        $cFile1 = '/downloads/' . $dos;
        $cFile2 = '/downloads/' . $dos2;
        $cExtra = "cextra=$pDtr";

        $fedi = $cRoot . $dos;
        $fedi2 = $cRoot . $dos2;
        if (file_exists($fedi) == true) {
            unlink($fedi);
        }
        if (file_exists($fedi2) == true) {
            unlink($fedi2);
        }

        $chr32 = chr(32);
        $ceroo = "0";
        $contra = 508; //488 478
        $pvpr = 15;
        $contra += $pvpr;
        if (strlen($pLug) == 0) {
            $contra -= 3;
        }
        if (strlen($pBlm) == 0) {
            $contra -= 50;
        }
        $contra = 3872;
        $jf = 0;
        $fp = fopen($fedi, 'a+');
        $fp2 = fopen($fedi2, 'a+');
        $sy = 0;
        $flag = 1;

        $xData = array();
        $it = 0;
        $cError = '';
        $nok = 0;
        $nok2 = 0;

        foreach ($xD1 as $z1) {
            $sub2 = $z1["subid2xx"];
            $sub1 = $z1["subidxxx"];
            $jf++;
            $supercadena = '';
            $colorsub = "1";
            if (strlen($z1['limstkxx']) == 0) {
                $flag = 0;
                $colorsub = "2";
                $cError .= "- DO: <font color='#FF0000'>" . $z1['docidxxx'] . "</font> Subp: <font color='#0000FF'>" . $sub2 . "</font> No posee Autoadhesivo<br>";
            }
            $xData[$it]['docidxxx'] = $z1['docidxxx'];
            $xData[$it]['arcidxxx'] = $z1['arcidxxx'];
            $xData[$it]['subid2xx'] = $z1['subidxxx'];
            $xData[$it]['umcidxxx'] = $z1['umcidxxx'];
            $xData[$it]['modidxxx'] = $z1['modidxxx'];
            $xData[$it]['limacexx'] = $z1['limacexx'];
            $xData[$it]['limstkxx'] = $z1['limstkxx'];
            $xData[$it]['limlevxx'] = $z1['limlevxx'];
            $xData[$it]['iterefxx'] = '';
            $xData[$it]['itecanxx'] = '';
            $xData[$it]['itevlrxx'] = '';
            $xData[$it]['doipedxx'] = $z1['doipedxx'];
            ;
            $xData[$it]['limdesxx'] = $z1['limdesxx'];
            $xData[$it]['color'] = $colorsub;
//$it++;
            $cad01 = str_pad(trim($z1['limstkxx']), 15, $chr32, STR_PAD_RIGHT);
            if (strlen($cad01) > 15) {
                $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Autoadhesivo supera los <b>15</b> digitos permitidos<br>";
            }
            $fed = $z1['limfstkx'];
            if (strlen($fed) == 10) {
                $fed = substr($fed, 0, 4) . substr($fed, 5, 2) . substr($fed, 8, 2);
            }
            $cad02 = str_pad($fed, 8, $ceroo, STR_PAD_RIGHT);
            $cad03 = str_pad(trim($z1['limacexx']), 16, $chr32, STR_PAD_RIGHT);
            if (strlen($cad03) > 16) {
                $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Aceptacion supera los <b>16</b> digitos permitidos<br>";
            }
            $fed = $z1['limfacex'];
            if (strlen($fed) == 10) {
                $fed = substr($fed, 0, 4) . substr($fed, 5, 2) . substr($fed, 8, 2);
            }
            $cad04 = str_pad($fed, 8, $ceroo, STR_PAD_RIGHT);
            $cad05 = str_pad(trim($z1['limlevxx']), 20, $chr32, STR_PAD_RIGHT);
            if (strlen($cad05) > 20) {
                $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Levante supera los <b>20</b> digitos permitidos<br>";
            }
            $fed = $z1['limflevx'];
            if (strlen($fed) == 10) {
                $fed = substr($fed, 0, 4) . substr($fed, 5, 2) . substr($fed, 8, 2);
            }
            $cad06 = str_pad($fed, 8, $ceroo, STR_PAD_RIGHT);
            $cad07 = str_pad($z1['odiidxxx'], 3, $chr32, STR_PAD_RIGHT);
            $cad08 = str_pad($z1['linidxxx'], 3, $chr32, STR_PAD_RIGHT);
            $cad09 = str_pad($z1['daaidxxx'], 5, $chr32, STR_PAD_RIGHT);
            if ($z1['doidtxxx'] == "" && $z1['tdeidxxx'] == '3') {
                $z1['doidtxxx'] = $pDtr;
                $qSdoi = $this->_db->select()
                    ->from("{$this->_default}.{$this->_reldoi}", "doifdtxx")
                    ->where('docidxxx=?', "{$pDoc}");

                $xDoi = $this->_db->fetchRow($qSdoi);
                if ($xDoi != null) {
                    $z1['doifdtxx'] = $xDoi["doifdtxx"];
                }
            }
            $cad10 = str_pad($z1['doidtxxx'], 30, $chr32, STR_PAD_RIGHT);
//$cad10 = substr($cad10, 0, 20);
            $fed = $z1['doifdtxx'];
            if (strlen($fed) == 10) {
                $fed = substr($fed, 0, 4) . substr($fed, 5, 2) . substr($fed, 8, 2);
            }

            $cad11 = str_pad($fed, 8, $ceroo, STR_PAD_RIGHT);
            $cad12 = str_pad($z1['facid2xx'], 25, $chr32, STR_PAD_RIGHT);
            $z1['pieidxxx'] = '';
            $cad13 = substr(str_pad($z1['pieidxxx'], 8, $chr32, STR_PAD_RIGHT), 0, 8);
            if (strlen($cad13) > 8) {
                $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Proveedor supera los <b>8</b> digitos permitidos<br>";
            }

////detalle Items
            $pedid = $z1['docidxxx'];
            $pPry = $pedid;
            $cpry = $pPry;
            $c14x = "_CADENA_REMPLAZO_IT_";
            $cad14 = str_pad($c14x, 20, $chr32, STR_PAD_RIGHT);
            $codadua = substr($z1["succodxx"], 1);
            $cad15 = str_pad($codadua, 3, $chr32, STR_PAD_RIGHT); //x
            $decex = explode('.', $z1['doitrmxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);
            $nent = str_pad($nint, 5, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad16 = $nent . $ndes;
            $cad17 = '';
            $qF = $this->_db->select()
                ->from("{$this->_default}.{$this->_reldav}", array('facid2xx', 'fmonidxx', 'factor'))
                ->where("docidxxx=?", "{$z1['docidxxx']}");
            $xF = $this->_db->fetchAll($qF);
            $arf = array();
            $y = 0;
            $isd = 0;
            foreach ($xF as $z2) {
                $arf[$y]['facid2xx'] = $z2['facid2xx'];
                $arf[$y]['fmonidxx'] = $z2['fmonidxx'];
                $arf[$y]['factor'] = $z2['factor'];
                if ($z2['fmonidxx'] != "USD") {
                    $isd = 1;
                }
                $arf[$y]['dolar'] = $isd;
                $y++;
            }
            for ($x = 0;
                $x < count($arf);
                $x++) {
                if ($arf[$x]['facid2xx'] == $z1['facid2xx']) {
                    $decex = explode('.', $arf[$x]['factor']);
                    $nint = $decex[0];
                    $fusd = $arf[$x]['dolar'];
                    $ndec = "";
                    if ($fusd == 1) {
                        $ndec = substr($decex[1], 0, 6);
                    } else {
                        $ndec = substr($decex[1], 0, 2);
                    }

                    $nent = str_pad($nint, 5, '0', STR_PAD_LEFT);
                    $ndes = str_pad($ndec, 6, '0', STR_PAD_RIGHT);
                    $cad17 = $nent . $ndes;
                    break;
                }
            }
            $cad18 = str_pad($z1['arcidxxx'], 10, $chr32, STR_PAD_RIGHT);
            $cad19 = str_pad($z1['modidxxx'], 4, $chr32, STR_PAD_RIGHT);
            $cad20 = str_pad($z1['timidxxx'], 2, $chr32, STR_PAD_RIGHT);

            $decex = explode('.', $z1['limpbrxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad21 = $nent . $ndes;

            $decex = explode('.', $z1['limpnexx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad22 = $nent . $ndes;
            $cad23 = str_pad($z1['umcidxxx'], 3, $chr32, STR_PAD_RIGHT);

            $decex = explode('.', $z1['limcanxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 4);

            $nent = str_pad($nint, 7, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 4, '0', STR_PAD_RIGHT);
            $cad24 = $nent . $ndes;

            $decex = explode('.', $z1['limvlrxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad25 = $nent . $ndes;

            $decex = explode('.', $z1['limflexx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad26 = $nent . $ndes;

            $decex = explode('.', $z1['limsegxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad27 = $nent . $ndes;

            $decex = explode('.', $z1['limotrxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad28 = $nent . $ndes;

            $decex = explode('.', $z1['limajuxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad29 = $nent . $ndes;
            $lrimid = strlen($z1['rimidxxx']) - 1; //numero de registro
//$vrim = substr($z1['RIMIDXXX'],1,$lrimid);
            $vrim = trim($z1['rimidxxx']);

            $cad30 = str_pad($vrim, 11, $chr32, STR_PAD_RIGHT);
            /*  if (strlen($cad30) > 11) {
              $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Registro supera los <b>11</b> digitos permitidos<br>";
              } */
            $cad31 = str_pad($z1['rimanoxx'], 4, $ceroo, STR_PAD_LEFT);

            $decex = explode('.', $z1['arcporxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 3, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad32 = $nent . $ndes;

            $decex = explode('.', $z1['limgraxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
//$ndes = str_pad($ndec,2,'0',STR_PAD_RIGHT); 
            $cad33 = $nent;

            $cad34 = 'N';
            if ($z1['limgraxx'] > 0) {
                $cad34 = 'N';
            }

            $decex = explode('.', $z1['arcivaxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 3, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad35 = $nent . $ndes;

            $decex = explode('.', $z1['limsubtx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
            $cad36 = $nent;
            $cad37 = 'N';
            if ($z1['limsubtx'] > 0) {
                $cad37 = 'N';
            }

            $decex = explode('.', $z1['subpansa']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
            $cad38 = $nent;

            $decex = explode('.', $z1['subpanot']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
            $cad39 = $nent;

            $decex = explode('.', $z1['limpanxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
            $cad40 = $nent;

            $decex = explode('.', $z1['totalpag']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $vefectivo = "0"; //0
            $nent = str_pad($vefectivo, 13, '0', STR_PAD_LEFT); //$nint
            $cad41 = $nent;

            $vcheque = "0"; //0
            $nent = str_pad("0", 13, "0", STR_PAD_LEFT);
            $cad42 = $nent;

            $ncheque = str_pad(" ", 10, $chr32, STR_PAD_LEFT); //$z1["docidxxx"]
            $cad43 = str_pad($ncheque, 10, $chr32, STR_PAD_RIGHT);

            if (strlen($cad43) > 10) {
                $cad43 = substr($cad43, 0, 10);
                $cad43 = str_pad($cad43, 10, $chr32, STR_PAD_RIGHT);
            }

            $rconv = 'N';
            $cad44 = $rconv;

            $drop = 'N'; //$pDro;
            $luent = $pLug;
            $blmadre = $pBlm;

            $cad45 = str_pad($drop, 1, $chr32, STR_PAD_RIGHT);

            $cad46 = str_pad("0", 3, $ceroo, STR_PAD_RIGHT); //""$luent
            // $cad47 = "";

            /* if (strlen($luent) > 0) {
              $cad46 = str_pad($luent, 3, $chr32, STR_PAD_RIGHT);
              }
              if (strlen($blmadre) > 0) {
              $cad47 = str_pad($blmadre, 50, $chr32, STR_PAD_RIGHT);
              }
              if (strlen($cad47) > 50) {
              $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Bl Madrea supera los <b>50</b> digitos permitidos<br>";
              } */
            //nuevos datos
            $cad47 = str_pad($z1["tdeidxxx"], 1, $chr32, STR_PAD_RIGHT); //
            $cad48 = str_pad($z1["limexpxx"], 20, $chr32, STR_PAD_RIGHT); //x colocarle le origen exp anterior
            $feex = $z1["limfexpx"];
            if (strlen($feex) == 10) {
                $feex = substr($feex, 0, 4) . substr($feex, 5, 2) . substr($feex, 8, 2);
            }
            $cad49 = str_pad($feex, 8, $chr32, STR_PAD_RIGHT); //y cerooo
            $cad50 = str_pad($z1["odiidxx4"], 3, $chr32, STR_PAD_RIGHT); //z
            $cad51 = str_pad($z1["doimcxxx"], 20, $chr32, STR_PAD_RIGHT);

            $fecm = $z1["doifmcxx"];
            if (strlen($fecm) == 10) {
                $fecm = substr($fecm, 0, 4) . substr($fecm, 5, 2) . substr($fecm, 8, 2);
            }
            $cad52 = str_pad($fecm, 8, $chr32, STR_PAD_RIGHT);

            $cad53 = str_pad($z1["paiidnxx"], 20, $chr32, STR_PAD_RIGHT); //subpaiid pais de procedencia
            $cad54 = str_pad($z1["mtridxxx"], 20, $chr32, STR_PAD_RIGHT);

            $qPai = $this->_db->select()
                ->from("{$this->_default}.{$this->_relpai}", array('paiidxxx', 'paiidnxx'))
                ->where("paiidxxx = ?", "{$z1['banidxxx']}")
                ->where("regestxx = ?", "ACTIVO");
            $xPai = $this->_db->fetchAll($qPai);
            foreach ($xPai as $z4) {
                $bandera = $z4['paiidnxx'];
            }

            $cad55 = str_pad($bandera, 20, $chr32, STR_PAD_RIGHT); //banidxxx
            $cad56 = str_pad($z1["depidxxx"], 20, $chr32, STR_PAD_RIGHT); //traer de base datos depid2xx -clidepid
            $cad57 = str_pad(round($z1["subcuoxx"]), 3, $chr32, STR_PAD_RIGHT);

            $decex = explode('.', $z1['subcuovl']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad58 = $nent . $ndes;

            $cad59 = str_pad(round($z1["subperxx"]), 3, $chr32, STR_PAD_RIGHT);
            $cad60 = str_pad($z1["subpande"], 20, $chr32, STR_PAD_RIGHT);
            $cad61 = str_pad($z1["aceidxxx"], 20, $chr32, STR_PAD_RIGHT);
            $cad62 = str_pad($z1["fpiidxxx"], 20, $chr32, STR_PAD_RIGHT);
            $cad63 = str_pad($z1["subpand2"], 20, $chr32, STR_PAD_RIGHT);
            $cad64 = str_pad($z1["temidxxx"], 20, $chr32, STR_PAD_RIGHT);

            $decex = explode('.', $z1['limbulxx']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 5, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad65 = $nent . $ndes;

            $cad66 = str_pad($z1["limsubxx"], 3, $chr32, STR_PAD_RIGHT);
            $cad67 = str_pad($z1["triidxxx"], 20, $chr32, STR_PAD_RIGHT); // numero de registro revisado
            $cad68 = str_pad($z1["oinidxxx"], 20, $chr32, STR_PAD_RIGHT);
            $cad69 = str_pad($z1["rimanoxx"], 4, $chr32, STR_PAD_RIGHT);
            $cad70 = str_pad($z1["rimpvxxx"], 20, $chr32, STR_PAD_RIGHT);
            $cad71 = str_pad($z1["subpvpro"], 20, $chr32, STR_PAD_RIGHT);

            $decex = explode('.', $z1['subsaltp']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 11, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad72 = $nent . $ndes;

            $decex = explode('.', $z1['subdcotp']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 11, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad73 = $nent . $ndes;

            $decex = explode('.', $z1['subanttp']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 11, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad74 = $nent . $ndes;

            $decex = explode('.', $z1['subsantp']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 11, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad75 = $nent . $ndes;

            $decex = explode('.', $z1['subrestp']);
            $nint = $decex[0];
            $ndec = substr($decex[1], 0, 2);

            $nent = str_pad($nint, 11, '0', STR_PAD_LEFT);
            $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
            $cad76 = $nent . $ndes;
            $cad77 = str_pad("", 18, $ceroo, STR_PAD_RIGHT);
            $desdec = $z1["limdesxx"];
            $desdec = str_replace(array(chr(27), chr(13), chr(9), chr(10)), array(" ", " ", " ", " "), $desdec);
            $desdec = utf8_decode($desdec);
            $cad78 = str_pad($desdec, 3000, $chr32, STR_PAD_RIGHT); //$z1["limdesxx"]
            ////////////////////////////////////////////
            // Verificacion de tamaños

            $longitudes = array(
                15, 8, 16, 8, 20, 8, 3, 3, 5, 30, 8, 25, 8, 20, 3, 7, 11, 10, 4, 2, 11,
                11, 3, 11, 11, 11, 11, 11, 11, 11, 4, 5, 13, 1, 5, 13, 1, 13, 13, 13, 13,
                13, 10, 1, 1, 3, 1, 20, 8, 3, 20, 8, 20, 20, 20, 20, 3, 11, 3, 20, 20, 20,
                20, 20, 7, 3, 20, 20, 4, 20, 20, 13, 13, 13, 13, 13, 18, 3000
            ); // Array con las longitudes máximas de cada cadena
            $cadenas = array(
                $cad01, $cad02, $cad03, $cad04, $cad05, $cad06, $cad07, $cad08, $cad09, $cad10,
                $cad11, $cad12, $cad13, $cad14, $cad15, $cad16, $cad17, $cad18, $cad19, $cad20,
                $cad21, $cad22, $cad23, $cad24, $cad25, $cad26, $cad27, $cad28, $cad29, $cad30,
                $cad31, $cad32, $cad33, $cad34, $cad35, $cad36, $cad37, $cad38, $cad39, $cad40,
                $cad41, $cad42, $cad43, $cad44, $cad45, $cad46, $cad47, $cad48, $cad49, $cad50,
                $cad51, $cad52, $cad53, $cad54, $cad55, $cad56, $cad57, $cad58, $cad59, $cad60,
                $cad61, $cad62, $cad63, $cad64, $cad65, $cad66, $cad67, $cad68, $cad69, $cad70,
                $cad71, $cad72, $cad73, $cad74, $cad75, $cad76, $cad77, $cad78
            ); // Array con las cadenas a comprobar
            $cad14 = $z1['docidxxx'];
            for ($i = 0; $i <= count($longitudes); $i++) {
                if (strlen($cadenas[$i]) > $longitudes[$i]) {
                    $cadenas[$i] = substr($cadenas[$i], 0, $longitudes[$i]);
                } else {
                    $cadenas[$i] = $cadenas[$i];
                }
            }
////PLAN VALLEJO
            $vrimpv = $z1['rimpvxxx'];
            $vrimpr = $z1['subpvpro'];
            if ($vrimpr == "0000") {
                $vrimpr = "";
            }
            /* $cad48 = str_pad($vrimpv, 10, $chr32, STR_PAD_RIGHT);
              if (strlen($cad48) > 10) {
              $cError .= "- DO <font color = '#FF0000'>{$z1['docidxxx']}</font> Subp: <font color = '#0000FF'>$sub2</font> Plan Vallejo supera los <b>10</b> digitos permitidos<br>";
              }
              $cad49 = str_pad($vrimpr, 5, $chr32, STR_PAD_RIGHT); */
///FIN PLAN VALLEJO
            /* $supercadena = "{$cad01}{$cad02}{$cad03}{$cad04}{$cad05}{$cad06}{$cad07}{$cad08}{$cad09}{$cad10}";
              $supercadena .= "{$cad11}{$cad12}{$cad13}{$cad14}{$cad15}{$cad16}{$cad17}{$cad18}{$cad19}{$cad20}";
              $supercadena .= "{$cad21}{$cad22}{$cad23}{$cad24}{$cad25}{$cad26}{$cad27}{$cad28}{$cad29}{$cad30}";
              $supercadena .= "{$cad31}{$cad32}{$cad33}{$cad34}{$cad35}{$cad36}{$cad37}{$cad38}{$cad39}{$cad40}";
              $supercadena .= "{$cad41}{$cad42}{$cad43}{$cad44}{$cad45}{$cad46}{$cad47}{$cad48}{$cad49}{$cad50}";
              $supercadena .= "{$cad51}{$cad52}{$cad53}{$cad54}{$cad55}{$cad56}{$cad57}{$cad58}{$cad59}{$cad60}";
              $supercadena .= "{$cad61}{$cad62}{$cad63}{$cad64}{$cad65}{$cad66}{$cad67}{$cad68}{$cad69}{$cad70}";
              $supercadena .= "{$cad71}{$cad72}{$cad73}{$cad74}{$cad75}{$cad76}{$cad77}{$cad78}"; */

            $supercadena = '';
            for ($i = 0; $i < count($cadenas); $i++) {
                if ($cadenas[$i] == "_CADENA_REMPLAZO_IT_") {
                    $qIt = $this->_db->select()
                        ->from("{$this->_default}.{$this->_relite}", array('doipedxx'))
                        ->where("docidxxx = ?", "{$z1['docidxxx']}")
                        ->where("subidxxx = ?", "{$sub1}")
                        ->where("regestxx = ?", "ACTIVO")
                        ->limit(1);
                    $xIt = $this->_db->fetchRow($qIt);
                    if ($xIt != null) {
                        $cadenas[$i] = str_pad($xIt['doipedxx'], 20, $chr32, STR_PAD_RIGHT);
                    }
                }
                $supercadena .= $cadenas[$i];
            }
            if (strlen($supercadena) == $contra) {//!=
                $nok++;
                //fwrite($fp, chr(13) . chr(10));
                if ($nok > 1) {
                    fwrite($fp, chr(13) . chr(10));
                }
                fwrite($fp, $supercadena);
            } else {
                //f_Mensaje(__FILE__,__LINE__,strlen($supercadena));
                $rs = $z1['subid2xx'];
                $cError .= "- DO: <font color = '#FF0000'>" . $z1['docidxxx'] . "</font> Subp: <font color = '#0000FF'>" . $rs . "</font> No cumple con longitud requerida " .
                    " , La longitud es de " . strlen($supercadena) . " debe ser maximo de 3872 en el archivo de Control " /* .  strlen($cadenas[0]) .
                      strlen($cadenas[1]) . " " . strlen($cadenas[2]) . " " . strlen($cadenas[3]) . " " . strlen($cadenas[4]) . " " . strlen($cadenas[5]) . " " . strlen($cadenas[6]) . " " . strlen($cadenas[7]) . " " . strlen($cadenas[8]) . " " . strlen($cadenas[9]) . " " . strlen($cadenas[10]) . " " .
                      strlen($cadenas[11]) . " " . strlen($cadenas[12]) . " " . strlen($cadenas[13]) . " " . strlen($cadenas[14]) . " " . strlen($cadenas[15]) . " " . strlen($cadenas[16]) . " " . strlen($cadenas[17]) . " " . strlen($cadenas[18]) . " " . strlen($cadenas[19]) . " " . strlen($cadenas[20]) . " " .
                      strlen($cadenas[21]) . " " . strlen($cadenas[22]) . " " . strlen($cadenas[23]) . " " . strlen($cadenas[24]) . " " . strlen($cadenas[25]) . " " . strlen($cadenas[26]) . " " . strlen($cadenas[27]) . " " . strlen($cadenas[28]) . " " . strlen($cadenas[29]) . " " . strlen($cadenas[30]) . " " .
                      strlen($cadenas[31]) . " " . strlen($cadenas[32]) . " " . strlen($cadenas[33]) . " " . strlen($cadenas[34]) . " " . strlen($cadenas[35]) . " " . strlen($cadenas[36]) . " " . strlen($cadenas[37]) . " " . strlen($cadenas[38]) . " " . strlen($cadenas[39]) . " " . strlen($cadenas[40]) . " " .
                      strlen($cadenas[41]) . " " . strlen($cadenas[42]) . " " . strlen($cadenas[43]) . " " . strlen($cadenas[44]) . " " . strlen($cadenas[45]) . " " . strlen($cadenas[46]) . " " . strlen($cadenas[47]) . " " . strlen($cadenas[48]) . " " . strlen($cadenas[49]) . " " . strlen($cadenas[50]) . " " .
                      strlen($cadenas[51]) . " " . strlen($cadenas[52]) . " " . strlen($cadenas[53]) . " " . strlen($cadenas[54]) . " " . strlen($cadenas[55]) . " " . strlen($cadenas[56]) . " " . strlen($cadenas[57]) . " " . strlen($cadenas[58]) . " " . strlen($cadenas[59]) . " " . strlen($cadenas[60]) . " " .
                      strlen($cadenas[61]) . " " . strlen($cadenas[62]) . " " . strlen($cadenas[63]) . " " . strlen($cadenas[64]) . " " . strlen($cadenas[65]) . " " . strlen($cadenas[66]) . " " . strlen($cadenas[67]) . " " . strlen($cadenas[68]) . " " . strlen($cadenas[69]) . " " . strlen($cadenas[70]) . " " .
                      strlen($cadenas[71]) . " " . strlen($cadenas[72]) . " " . strlen($cadenas[73]) . " " . strlen($cadenas[74]) . " " . strlen($cadenas[75]) . " " . strlen($cadenas[76]) . " " . strlen($cadenas[77]) . " " */
                    . "<br>";
                $flag = 0;
            }
            ////detalle Items
            $qIt = $this->_db->select()
                ->from("{$this->_default}.{$this->_relite}", array('proidxxx', 'iterefxx', 'itecanxx', 'itecandv', 'doipedxx', 'iteidxxx', 'itevlrxx', 'itedesco', 'itedesxx', 'arcidxxx'))
                ->where("docidxxx = ?", "{$z1['docidxxx']}")
                ->where("subidxxx = ?", "{$sub1}")
                ->where("regestxx = ?", "ACTIVO");
            $xIt = $this->_db->fetchAll($qIt);
            foreach ($xIt as $z3) {
                $refer = $z3["proidxxx"];
                $refer = str_replace("abb", "", $refer);
                $refer = str_replace("ABB", "", $refer);
                $iref = str_pad($refer, 25, $chr32, STR_PAD_RIGHT);
                $ican = $z3["itecanxx"];
                $ivlr = $z3["itevlrxx"] / $z3["itecanxx"];
                if ($z3["itecandv"] > 0) {
                    $ican = $z3["itecandv"];
                    $ivlr = $z3["itevlrxx"] / $z3["itecandv"];
                }
                $colorit = "3";
                if (strlen($refer) == 0 || strlen($z3["doipedxx"]) == 0) {
                    /* $flag = 0;
                      $colorit = "4";
                      $cError .= "- DO: <font color = '#FF0000'>" . $z1['docidxxx'] . "</font> Item: <font color = '#0000FF'>" . $z3['iteidxxx'] . '</font> debe tener Pedido y Producto<br>'; */
                }
                $decex = explode('.', $ican);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 4);
                $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 4, '0', STR_PAD_RIGHT);
                $cadcan = $nent . $ndes;
                $pedido = $z3['doipedxx'];
                //$pedido = $oUti->fnSoloNumeros($z3['doipedxx']);
                $pedido = str_pad(trim($pedido), 20, $chr32, STR_PAD_RIGHT);
                $decex = explode('.', $ivlr);
                $nint = $decex[0];
                $ndec = '0';
                if (count($decex) == 2) {
                    $ndec = substr($decex[1], 0, 6);
                }
                $nent = str_pad($nint, 10, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 6, '0', STR_PAD_RIGHT);
                $cadivr = $nent . $ndes;
                //$subpar = $cad18;
                //$doctra = $cad10;
                // $despro = $z1['limdesxx'];
                // $subpar = str_pad(trim($z1['arcidxxx']), 20, $chr32, STR_PAD_LEFT);
                $subpar = str_pad(trim($z3['arcidxxx']), 20, $chr32, STR_PAD_RIGHT);
                $factur = str_pad(trim($cad12), 30, $chr32, STR_PAD_RIGHT);
                $doctra = str_pad(trim($cad10), 30, $chr32, STR_PAD_RIGHT);
                $despro = "";

                if ($despro == "") {
                    $despro = strtoupper($z3['itedesin'] . " " . $z3['itedesco'] . " " . $z3['itedesxx']); //$z3['itedesco'] .
                }/*
                  if ($despro == "") {
                  $despro = strtoupper(stristr($z3['itedesco'], "PRODUCTO : "));
                  }
                 */
                $despro = str_replace(array(chr(27), chr(13), chr(9), chr(10)), array(" ", " ", " ", " "), $despro);
                $despro = utf8_decode($despro);
                $despro = str_pad(trim($despro), 1880, $chr32, STR_PAD_RIGHT);

                $cadenas2 = array($cad01, $iref, $cadcan, $pedido, $cadivr, $subpar, $factur, $doctra, $despro);
                $longitudes2 = array(15, 25, 13, 20, 16, 20, 30, 30, 1880);
                for ($i = 0; $i <= count($longitudes2); $i++) {
                    if (strlen($cadenas2[$i]) > $longitudes2[$i]) {
                        $cadenas2[$i] = substr($cadenas2[$i], 0, $longitudes2[$i]);
                    } else {
                        $cadenas2[$i] = $cadenas2[$i];
                    }
                }
                // $supercadena2 = "{$cad01}{$iref}{$cadcan}{$pedido}{$cadivr}{$subpar}{$factur}{$doctra}{$despro}"; // . $cad18 . $cad10;

                $supercadena2 = '';
                for ($i = 0; $i < count($cadenas2); $i++) {
                    $supercadena2 .= $cadenas2[$i];
                }

                if (strlen($supercadena2) == 2049) {//=  2049
                    $nok2++;
                    //fwrite($fp, chr(13) . chr(10));
                    if ($nok2 > 1) {
                        fwrite($fp2, chr(13) . chr(10));
                    }
                    fwrite($fp2, $supercadena2);
                } else {
                    //f_Mensaje(__FILE__,__LINE__,strlen($supercadena));
                    $rs = $z1['subid2xx'];
                    $cError .= "- DO: <font color = '#FF0000'>" . $z1['docidxxx'] . "</font> Subp: <font color = '#0000FF'>" . $rs . "</font> No cumple con longitud requerida " .
                        " La longitud es de" . strlen($supercadena2) . " debe ser maximo de 2049 el archivo de detalle"
                        /* strlen($cad01) . " " . strlen($iref) . " " . strlen($cadcan) . " " .
                          strlen($pedido) . " " . strlen($cadivr) . " " . strlen($subpar) . " " .
                          strlen($factur) . " " . strlen($doctra) . " " . strlen($despro) . "<br>"; */ . strlen($despro) . "<br>";
                    $flag = 0;
                }

                $vDa = array('docidxxx' => '',
                    'arcidxxx' => '',
                    'subid2xx' => $z3['iteidxxx'],
                    'umcidxxx' => '',
                    'modidxxx' => '',
                    'limacexx' => '',
                    'limstkxx' => '',
                    'limlevxx' => $z3['proidxxx'],
                    'iterefxx' => $z3['iterefxx'],
                    'itecanxx' => round($ican, 5),
                    'itevlrxx' => round($ivlr, 6),
                    'doipedxx' => $z3['doipedxx'],
                    'color' => $colorit);
                $xData[] = $vDa;
                $it++;
            }
            $it++;
        }
        fclose($fp);
        fclose($fp2);
        if ($flag == 1 && $it > 0) {
            echo "{\"success\":true,\"file1\":\"$cFile1\",\"file2\":\"$cFile2\",\"error\":\"\",\"content\":" . json_encode($xData) . "}";
        } else {
            if ($cError == '') {
                $cError = 'No se generaron Registros<br>';
            }
            echo "{\"success\":true,\"error\":\"$cError\"}";
        }
    }
    /* Fin de la clase */
    public function fnGenerar($pDtr, $pPry, $pLug, $pBlm, $pDro, $pDoc) {
        $cDbE = $_COOKIE['kDbExterna'];
        if ($cDbE == 'pruebasx' || $cDbE == 'customs2_pruebasx' || $cDbE == 'kuehnena') {
            $this->fnGenerarKN($pDtr, $pPry, $pLug, $pBlm, $pDro, $pDoc);
        } else {
            include 'utility.php';
            $oUti = new utility();
            $qSelect = $this->_db->select()
                ->from("{$this->_default}.{$this->_name}")
                ->where("doidtxxx=?", "{$pDtr}");
            if ($pDoc != '') {
                $qSelect->where('docidxxx=?', "{$pDoc}");
            }
            $qSelect->order(array('regfmodx DESC', 'reghmodx DESC'));
            $dos = "PCDEPT00.TXT";
            $dos2 = "PDDEPT00.TXT";
            $cRoot = $_SERVER['DOCUMENT_ROOT'] . '/downloads/';
            $cFile1 = '/downloads/' . $dos;
            $cFile2 = '/downloads/' . $dos2;
            $cExtra = "cextra=$pDtr";

            $fedi = $cRoot . $dos;
            $fedi2 = $cRoot . $dos2;
            if (file_exists($fedi) == true) {
                unlink($fedi);
            }
            if (file_exists($fedi2) == true) {
                unlink($fedi2);
            }

            $chr32 = chr(32);
            $ceroo = "0";
            $contra = 478;
            $pvpr = 15;
            $contra += $pvpr;
            if (strlen($pLug) == 0) {
                $contra -= 3;
            }
            if (strlen($pBlm) == 0) {
                $contra -= 50;
            }

            $jf = 0;
            $fp = fopen($fedi, 'a+');
            $fp2 = fopen($fedi2, 'a+');
            $sy = 0;
            $flag = 1;
            $xD1 = $this->_db->fetchAll($qSelect);
            $xData = array();
            $it = 0;
            $cError = '';
            $nok = 0;
            $nok2 = 0;
            if ($xD1 == null && $pDoc != '') {
                $qSelect = $this->_db->select()
                    ->from("{$this->_default}.{$this->_name}")
                    ->where('docidxxx=?', "{$pDoc}")
                    ->where("doidtxxx=?", "")
                    ->where('tdeidxxx=?', "3");
                $xD1 = $this->_db->fetchAll($qSelect);
            }
            foreach ($xD1 as $z1) {
                $sub2 = $z1["subid2xx"];
                $sub1 = $z1["subidxxx"];
                $jf++;
                $supercadena = '';
                $colorsub = "1";
                if (strlen($z1['limstkxx']) == 0) {
                    $flag = 0;
                    $colorsub = "2";
                    $cError .= "- DO: <font color='#FF0000'>" . $z1['docidxxx'] . "</font> Subp: <font color='#0000FF'>" . $sub2 . "</font> No posee Autoadhesivo<br>";
                }
                $xData[$it]['docidxxx'] = $z1['docidxxx'];
                $xData[$it]['arcidxxx'] = $z1['arcidxxx'];
                $xData[$it]['subid2xx'] = $z1['subidxxx'];
                $xData[$it]['umcidxxx'] = $z1['umcidxxx'];
                $xData[$it]['modidxxx'] = $z1['modidxxx'];
                $xData[$it]['limacexx'] = $z1['limacexx'];
                $xData[$it]['limstkxx'] = $z1['limstkxx'];
                $xData[$it]['limlevxx'] = $z1['limlevxx'];
                $xData[$it]['iterefxx'] = '';
                $xData[$it]['itecanxx'] = '';
                $xData[$it]['itevlrxx'] = '';
                $xData[$it]['doipedxx'] = "";
                $xData[$it]['color'] = $colorsub;
                //$it++;
                $cad01 = str_pad(trim($z1['limstkxx']), 15, $chr32, STR_PAD_RIGHT);
                if (strlen($cad01) > 15) {
                    $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Autoadhesivo supera los <b>15</b> digitos permitidos<br>";
                }
                $fed = $z1['limfstkx'];
                if (strlen($fed) == 10) {
                    $fed = substr($fed, 0, 4) . substr($fed, 5, 2) . substr($fed, 8, 2);
                }
                $cad02 = str_pad($fed, 8, $ceroo, STR_PAD_RIGHT);
                $cad03 = str_pad(trim($z1['limacexx']), 16, $chr32, STR_PAD_RIGHT);
                if (strlen($cad03) > 16) {
                    $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Aceptacion supera los <b>16</b> digitos permitidos<br>";
                }
                $fed = $z1['limfacex'];
                if (strlen($fed) == 10) {
                    $fed = substr($fed, 0, 4) . substr($fed, 5, 2) . substr($fed, 8, 2);
                }
                $cad04 = str_pad($fed, 8, $ceroo, STR_PAD_RIGHT);
                $cad05 = str_pad(trim($z1['limlevxx']), 20, $chr32, STR_PAD_RIGHT);
                if (strlen($cad05) > 20) {
                    $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Levante supera los <b>20</b> digitos permitidos<br>";
                }
                $fed = $z1['limflevx'];
                if (strlen($fed) == 10) {
                    $fed = substr($fed, 0, 4) . substr($fed, 5, 2) . substr($fed, 8, 2);
                }
                $cad06 = str_pad($fed, 8, $ceroo, STR_PAD_RIGHT);
                $cad07 = str_pad($z1['odiidxxx'], 3, $chr32, STR_PAD_RIGHT);
                $cad08 = str_pad($z1['linidxxx'], 3, $chr32, STR_PAD_RIGHT);
                $cad09 = str_pad($z1['daaidxxx'], 5, $chr32, STR_PAD_RIGHT);
                if ($z1['doidtxxx'] == "" && $z1['tdeidxxx'] == '3') {
                    $z1['doidtxxx'] = $pDtr;
                    $qSdoi = $this->_db->select()
                        ->from("{$this->_default}.{$this->_reldoi}", "doifdtxx")
                        ->where('docidxxx=?', "{$pDoc}");

                    $xDoi = $this->_db->fetchRow($qSdoi);
                    if ($xDoi != null) {
                        $z1['doifdtxx'] = $xDoi["doifdtxx"];
                    }
                }
                $cad10 = str_pad($z1['doidtxxx'], 20, $chr32, STR_PAD_RIGHT);
                $cad10 = substr($cad10, 0, 20);
                $fed = $z1['doifdtxx'];
                if (strlen($fed) == 10) {
                    $fed = substr($fed, 0, 4) . substr($fed, 5, 2) . substr($fed, 8, 2);
                }

                $cad11 = str_pad($fed, 8, $ceroo, STR_PAD_RIGHT);
                $cad12 = str_pad($z1['facid2xx'], 25, $chr32, STR_PAD_RIGHT);
                $z1['pieidxxx'] = '';
                $cad13 = substr(str_pad($z1['pieidxxx'], 8, $chr32, STR_PAD_RIGHT), 0, 8);
                if (strlen($cad13) > 8) {
                    $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Proveedor supera los <b>8</b> digitos permitidos<br>";
                }
                $cpry = $pPry;
                $cad14 = str_pad($cpry, 20, $chr32, STR_PAD_RIGHT);
                $cad15 = str_pad("261", 3, $chr32, STR_PAD_RIGHT);
                $decex = explode('.', $z1['doitrmxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);
                $nent = str_pad($nint, 5, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad16 = $nent . $ndes;
                $cad17 = '';
                $qF = $this->_db->select()
                    ->from("{$this->_default}.{$this->_reldav}", array('facid2xx', 'fmonidxx', 'factor'))
                    ->where("docidxxx=?", "{$z1['docidxxx']}");
                $xF = $this->_db->fetchAll($qF);
                $arf = array();
                $y = 0;
                $isd = 0;
                foreach ($xF as $z2) {
                    $arf[$y]['facid2xx'] = $z2['facid2xx'];
                    $arf[$y]['fmonidxx'] = $z2['fmonidxx'];
                    $arf[$y]['factor'] = $z2['factor'];
                    if ($z2['fmonidxx'] != "USD") {
                        $isd = 1;
                    }
                    $arf[$y]['dolar'] = $isd;
                    $y++;
                }
                for ($x = 0; $x < count($arf); $x++) {
                    if ($arf[$x]['facid2xx'] == $z1['facid2xx']) {
                        $decex = explode('.', $arf[$x]['factor']);
                        $nint = $decex[0];
                        $fusd = $arf[$x]['dolar'];
                        $ndec = "";
                        if ($fusd == 1) {
                            $ndec = substr($decex[1], 0, 6);
                        } else {
                            $ndec = substr($decex[1], 0, 2);
                        }

                        $nent = str_pad($nint, 5, '0', STR_PAD_LEFT);
                        $ndes = str_pad($ndec, 6, '0', STR_PAD_RIGHT);
                        $cad17 = $nent . $ndes;
                        break;
                    }
                }
                $cad18 = str_pad($z1['arcidxxx'], 10, $chr32, STR_PAD_RIGHT);
                $cad19 = str_pad($z1['modidxxx'], 4, $chr32, STR_PAD_RIGHT);
                $cad20 = str_pad($z1['timidxxx'], 2, $chr32, STR_PAD_RIGHT);

                $decex = explode('.', $z1['limpbrxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad21 = $nent . $ndes;

                $decex = explode('.', $z1['limpnexx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad22 = $nent . $ndes;
                $cad23 = str_pad($z1['umcidxxx'], 3, $chr32, STR_PAD_RIGHT);

                $decex = explode('.', $z1['limcanxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 4);

                $nent = str_pad($nint, 7, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 4, '0', STR_PAD_RIGHT);
                $cad24 = $nent . $ndes;

                $decex = explode('.', $z1['limvlrxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad25 = $nent . $ndes;

                $decex = explode('.', $z1['limflexx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad26 = $nent . $ndes;

                $decex = explode('.', $z1['limsegxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad27 = $nent . $ndes;

                $decex = explode('.', $z1['limotrxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad28 = $nent . $ndes;

                $decex = explode('.', $z1['limajuxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 9, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad29 = $nent . $ndes;

                $lrimid = strlen($z1['rimidxxx']) - 1;
                //$vrim = substr($z1['RIMIDXXX'],1,$lrimid);
                $vrim = trim($z1['rimidxxx']);

                $cad30 = str_pad($vrim, 11, $chr32, STR_PAD_RIGHT);
                if (strlen($cad30) > 11) {
                    $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Registro supera los <b>11</b> digitos permitidos<br>";
                }
                $cad31 = str_pad($z1['rimanoxx'], 4, $ceroo, STR_PAD_LEFT);

                $decex = explode('.', $z1['arcporxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 3, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad32 = $nent . $ndes;

                $decex = explode('.', $z1['limgraxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
                //$ndes = str_pad($ndec,2,'0',STR_PAD_RIGHT); 
                $cad33 = $nent;

                $cad34 = 'S';
                if ($z1['limgraxx'] > 0) {
                    $cad34 = 'N';
                }

                $decex = explode('.', $z1['arcivaxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 3, '0', STR_PAD_LEFT);
                $ndes = str_pad($ndec, 2, '0', STR_PAD_RIGHT);
                $cad35 = $nent . $ndes;

                $decex = explode('.', $z1['limsubtx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
                $cad36 = $nent;
                $cad37 = 'S';
                if ($z1['limsubtx'] > 0) {
                    $cad37 = 'N';
                }

                $decex = explode('.', $z1['subpansa']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
                $cad38 = $nent;

                $decex = explode('.', $z1['subpanot']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
                $cad39 = $nent;

                $decex = explode('.', $z1['limpanxx']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
                $cad40 = $nent;

                $decex = explode('.', $z1['totalpag']);
                $nint = $decex[0];
                $ndec = substr($decex[1], 0, 2);

                $nent = str_pad($nint, 13, '0', STR_PAD_LEFT);
                $cad41 = $nent;

                $vcheque = '0';
                $nent = str_pad($vcheque, 13, '0', STR_PAD_LEFT);
                $cad42 = $nent;

                $ncheque = '';
                $cad43 = str_pad($ncheque, 10, $chr32, STR_PAD_RIGHT);

                $rconv = 'N';
                $cad44 = $rconv;

                $drop = $pDro;
                $luent = $pLug;
                $blmadre = $pBlm;

                $cad46 = "";
                $cad47 = "";

                $cad45 = str_pad($drop, 1, $chr32, STR_PAD_RIGHT);

                if (strlen($luent) > 0) {
                    $cad46 = str_pad($luent, 3, $chr32, STR_PAD_RIGHT);
                }
                if (strlen($blmadre) > 0) {
                    $cad47 = str_pad($blmadre, 50, $chr32, STR_PAD_RIGHT);
                }
                if (strlen($cad47) > 50) {
                    $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Bl Madrea supera los <b>50</b> digitos permitidos<br>";
                }

                ////PLAN VALLEJO
                $vrimpv = $z1['rimpvxxx'];
                $vrimpr = $z1['subpvpro'];
                if ($vrimpr == "0000") {
                    $vrimpr = "";
                }
                $cad48 = str_pad($vrimpv, 10, $chr32, STR_PAD_RIGHT);
                if (strlen($cad48) > 10) {
                    $cError .= "- DO <font color='#FF0000'>{$z1['docidxxx']}</font> Subp: <font color='#0000FF'>$sub2</font> Plan Vallejo supera los <b>10</b> digitos permitidos<br>";
                }
                $cad49 = str_pad($vrimpr, 5, $chr32, STR_PAD_RIGHT);
                ///FIN PLAN VALLEJO
                $supercadena = $cad01 . $cad02 . $cad03 . $cad04 . $cad05 . $cad06 . $cad07 . $cad08 . $cad09 . $cad10;
                $supercadena .= $cad11 . $cad12 . $cad13 . $cad14 . $cad15 . $cad16 . $cad17 . $cad18 . $cad19 . $cad20;
                $supercadena .= $cad21 . $cad22 . $cad23 . $cad24 . $cad25 . $cad26 . $cad27 . $cad28 . $cad29 . $cad30;
                $supercadena .= $cad31 . $cad32 . $cad33 . $cad34 . $cad35 . $cad36 . $cad37 . $cad38 . $cad39 . $cad40;
                $supercadena .= $cad41 . $cad42 . $cad43 . $cad44 . $cad45 . $cad46 . $cad47 . $cad48 . $cad49;
                if (strlen($supercadena) == $contra) {
                    $nok++;
                    //fwrite($fp, chr(13) . chr(10));
                    if ($nok > 1) {
                        fwrite($fp, chr(13) . chr(10));
                    }
                    fwrite($fp, $supercadena);
                } else {
                    //f_Mensaje(__FILE__,__LINE__,strlen($supercadena));
                    $rs = $z1['subid2xx'];
                    $cError .= "- DO: <font color='#FF0000'>" . $z1['docidxxx'] . "</font> Subp: <font color='#0000FF'>" . $rs . "</font> No cumple con longitud requerida<br>";
                    $flag = 0;
                }
                ////detalle Items
                $qIt = $this->_db->select()
                    ->from("{$this->_default}.{$this->_relite}", array('proidxxx', 'iterefxx', 'itecanxx', 'itecandv', 'doipedxx', 'iteidxxx', 'itevlrxx'))
                    ->where("docidxxx=?", "{$z1['docidxxx']}")
                    ->where("subidxxx=?", "{$sub1}")
                    ->where("regestxx=?", "ACTIVO");
                $xIt = $this->_db->fetchAll($qIt);
                foreach ($xIt as $z3) {
                    $refer = $z3["proidxxx"];
                    $iref = str_pad($refer, 25, chr(32), STR_PAD_RIGHT);
                    $ican = $z3["itecanxx"];
                    $ivlr = $z3["itevlrxx"] / $z3["itecanxx"];
                    if ($z3["itecandv"] > 0) {
                        $ican = $z3["itecandv"];
                        $ivlr = $z3["itevlrxx"] / $z3["itecandv"];
                    }
                    $colorit = "3";
                    if (strlen($refer) == 0 || strlen($z3["doipedxx"]) == 0) {
                        /* $flag = 0;
                          $colorit = "4";
                          $cError .= "- DO: <font color='#FF0000'>" . $z1['docidxxx'] . "</font> Item: <font color='#0000FF'>" . $z3['iteidxxx'] . '</font> debe tener Pedido y Producto<br>'; */
                    }
                    $decex = explode('.', $ican);
                    $nint = $decex[0];
                    $ndec = substr($decex[1], 0, 4);
                    $nent = str_pad($nint, 7, '0', STR_PAD_LEFT);
                    $ndes = str_pad($ndec, 4, '0', STR_PAD_RIGHT);
                    $cadcan = $nent . $ndes;
                    $pedido = $oUti->fnSoloNumeros($z1['doipedxx']);
                    $pedido = str_pad(trim($pedido), 20, $chr32, STR_PAD_RIGHT);
                    $decex = explode('.', $ivlr);
                    $nint = $decex[0];
                    $ndec = '0';
                    if (count($decex) == 2) {
                        $ndec = substr($decex[1], 0, 6);
                    }
                    $nent = str_pad($nint, 10, '0', STR_PAD_LEFT);
                    $ndes = str_pad($ndec, 6, '0', STR_PAD_RIGHT);
                    $cadivr = $nent . $ndes;
                    $supercadena2 = $cad01 . $iref . $cadcan . $pedido . $cadivr;
                    $nok2++;
                    if ($nok2 > 1) {
                        fwrite($fp2, chr(13) . chr(10));
                    }
                    fwrite($fp2, $supercadena2);
                    $vDa = array('docidxxx' => '',
                        'arcidxxx' => '',
                        'subid2xx' => $z3['iteidxxx'],
                        'umcidxxx' => '',
                        'modidxxx' => '',
                        'limacexx' => '',
                        'limstkxx' => '',
                        'limlevxx' => $z3['proidxxx'],
                        'iterefxx' => $z3['iterefxx'],
                        'itecanxx' => round($ican, 5),
                        'itevlrxx' => round($ivlr, 6),
                        'doipedxx' => $z3['doipedxx'],
                        'color' => $colorit);
                    $xData[] = $vDa;
                    /* $xData[$it]['docidxxx'] = '';
                      $xData[$it]['arcidxxx'] = '';
                      $xData[$it]['subid2xx'] = $z3['iteidxxx'];
                      $xData[$it]['umcidxxx'] = '';
                      $xData[$it]['modidxxx'] = '';
                      $xData[$it]['limacexx'] = '';
                      $xData[$it]['limstkxx'] = '';
                      $xData[$it]['limlevxx'] = $z3['proidxxx'];
                      $xData[$it]['iterefxx'] = $z3['iterefxx'];
                      $xData[$it]['itecanxx'] = round($ican, 5);
                      $xData[$it]['itevlrxx'] = round($ivlr, 6);
                      $xData[$it]['doipedxx'] = $z3['doipedxx'];
                      $xData[$it]['color'] = $colorit; */
                    $it++;
                }
                $it++;
            }
            fclose($fp);
            fclose($fp2);
            if ($flag == 1 && $it > 0) {
                echo "{\"success\":true,\"file1\":\"$cFile1\",\"file2\":\"$cFile2\",\"error\":\"\",\"content\":" . json_encode($xData) . "}";
            } else {
                if ($cError == '') {
                    $cError = 'No se generaron Registros<br>';
                }
                echo "{\"success\":true,\"error\":\"$cError\"}";
            }
        }
        /* Fin de la clase */
    }
}