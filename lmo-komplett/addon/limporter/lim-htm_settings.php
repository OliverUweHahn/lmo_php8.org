<?PHP
//
// Limporter Version 1.0
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//

require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/limporter/lim-functions.php");
require_once(PATH_TO_ADDONDIR."/limporter/lim-classes.php");
require_once(PATH_TO_ADDONDIR."/limporter/linkcheck.php");


if(!isset($header)){$header="0";}
if(!isset($xdetailsCheck)){$xdetailsCheck=0;}
if(!isset($showall)){$showall="0";}
if(!isset($csvchar)){$csvchar=";";}
if(!isset($xlrow)) {$xlrow=null;}
if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
$offset = $xoffset - 1;
if(!isset($datarows) or ($datarows < 1) ){$datarows=10;}
if(isset($ximporturl)){

	$row = 0;
	$dataArray = buildFieldArray($ximporturl,$xdetailsCheck);
	$rows = array();
	$num = 0;
	$col = 0;
	foreach ($dataArray as $dataRow) {
		if ($row >= $offset) {
			$data = split("#",$dataRow);
		   	$rows[] = $data;
		    $num = count($data);
			if ($num>$col) $col = $num;
		}
		if ($xlrow>0 and $row > ($xlrow-2)) break;
		$row++;
	}
	for ($x=0;$x < count($rows);$x++) {
        $tmp = $rows[$x];
        $rows[$x] = array_pad($tmp,$col,"");
	}
}

?>
    <tr>
      <td class ="lmost5" colspan=3>&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class ="lmost5" colspan=2 align="left">HTML - Importeinstellungen</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right">&nbsp;</td>
      <td class="lmost5" align="left">Import von Zeile&nbsp;<input class="lmo-formular-input" type="text" name="xoffset" size="3" maxlength="3" value=<?PHP echo $xoffset; ?>>&nbsp;-&nbsp;<input class="lmo-formular-input" type="text" name="xlrow" size="3" maxlength="3" value=<?PHP echo $xlrow; ?>>&nbsp;<a href='<?PHP echo $ximporturl;?>' target="_blank">Quelle zeigen</a></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"></td>
      <td class="lmost5" align="left"><input class="lmo-formular-input" type="checkbox" name="header" <?PHP if($header==1){echo " checked";} ?> value="1">&nbsp;1.&nbsp;Datenzeile&nbsp;enth&auml;lt&nbsp;Spaltentitel</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"></td>
      <td class="lmost5" align="left"><input class="lmo-formular-input" type="checkbox" name="xdetailsCheck" <?PHP if($xdetailsCheck==1){echo " checked";} ?> value="1">&nbsp;auf m�gliche Folgezeile pr�fen (z.B. SIS-Handball)</td>
    </tr>
    <tr>
      <td class="lmost5" colspan="3">&nbsp;</td>
    </tr>
<?PHP include(PATH_TO_ADDONDIR."/limporter/lim-colums_select.php");?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5"></td>
      <td align="left" class ="lmost5">&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="left" colspan=2 class="lmost5"><input class="lmo-formular-button" type="submit" name="vorschau" value="Vorschau">&nbsp;&nbsp;nicht verwendete Spalten ausblenden&nbsp;<input class="lmo-formular-input" type="checkbox" name="showall" <?PHP if($showall==1){echo " checked";} ?> value="1">
    </tr>
    <tr>
      <td colspan=3 class="lmost5">
<?PHP
$prev="addon/limporter/lim-htm_preview.php?file=".$limporter_importDir."/".$fileName."&pv=".$pv."&hd=".$header."&cdetails=".$xdetailsCheck."&ch=".$csvchar."&all=".$showall."&dr=".$datarows;
$prev = $prev."&xoffset=".$xoffset."&xlrow=".$xlrow."&c_nr=".$cols['NR'][0]."&c_h=".$cols['HEIM'][0]."&c_g=".$cols['GAST'][0]."&c_th=".$cols['THEIM'][0];
$prev = $prev."&c_tg=".$cols['TGAST'][0]."&c_d=".$cols['DATUM'][0]."&c_z=".$cols['ZEIT'][0]."&c_n=".$cols['NOTIZ'][0];
$prev = $prev."&f_nr=".$cols['NR'][1]."&f_h=".$cols['HEIM'][1]."&f_g=".$cols['GAST'][1]."&f_th=".$cols['THEIM'][1];
$prev = $prev."&f_tg=".$cols['TGAST'][1]."&f_d=".$cols['DATUM'][1]."&f_z=".$cols['ZEIT'][1]."&f_n=".$cols['NOTIZ'][1];
echo "<iframe src=\"".$prev."\" width=\"450\" height=\"200\"></iframe>";
?>
      </td>
    </tr>