<?php
  echo"<div class='form-inline'>
    <select class='form-control' name='dag' id='dag'>
    <option value='01' selected>01</option>
    <option value='02'>02</option>
    <option value='03'>03</option>
    <option value='04'>04</option>
    <option value='05'>05</option>
    <option value='06'>06</option>
    <option value='07'>07</option>
    <option value='08'>08</option>
    <option value='09'>09</option>
    <option value='10'>10</option>
    <option value='11'>11</option>
    <option value='12'>12</option>
    <option value='13'>13</option>
    <option value='14'>14</option>
    <option value='15'>15</option>
    <option value='16'>16</option>
    <option value='17'>17</option>
    <option value='18'>18</option>
    <option value='19'>19</option>
    <option value='20'>20</option>
    <option value='21'>21</option>
    <option value='22'>22</option>
    <option value='23'>23</option>
    <option value='24'>24</option>
    <option value='25'>25</option>
    <option value='26'>26</option>
    <option value='27'>27</option>
    <option value='28'>28</option>
    <option value='29'>29</option>
    <option value='30'>30</option>
    <option value='31'>31</option>
    </select>";

    echo" ";

    echo"
    <select class='form-control' name='maned' id='mnd'>
    <option value='01'>Januar</option>
    <option value='02'>Februar</option>
    <option value='03'>Mars</option>
    <option value='04'>April</option>
    <option value='05'>Mai</option>
    <option value='06'>Juni</option>
    <option value='07'>Juli</option>
    <option value='08'>August</option>
    <option value='09'>September</option>
    <option value='10'>Oktober</option>
    <option value='11'>November</option>
    <option value='12'>Desember</option>
    </select>";

    echo" ";

    $yr = (date('Y'));
    $nyr = (date('Y')+1);


    echo"
    <select class='form-control' name='ar' id='ar'>
    <option value='". (date('Y')) ."'>" . (date('Y')) . "</option>
    <option value='". (date('Y')+1) ."'>" . (date('Y')+1) . "</option>
    </select></div>";
?>