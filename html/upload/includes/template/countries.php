<?php
/*
Copyright © 2009-2014 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!isset($cmtx_path)) { die('Access Denied.'); }

$cmtx_countries = '<select name="cmtx_country" class="cmtx_field cmtx_select_field cmtx_country_field" title="' . CMTX_TITLE_COUNTRY . '">
<option value="">' . CMTX_TOP_COUNTRY  . '</option>
<option value="">---</option>
<option value="' . CMTX_COUNTRY_US . '">' . CMTX_COUNTRY_US  . '</option>
<option value="' . CMTX_COUNTRY_UK . '">' . CMTX_COUNTRY_UK  . '</option>
<option value="' . CMTX_COUNTRY_IRELAND . '">' . CMTX_COUNTRY_IRELAND  . '</option>
<option value="' . CMTX_COUNTRY_CANADA . '">' . CMTX_COUNTRY_CANADA  . '</option>
<option value="' . CMTX_COUNTRY_AUSTRALIA . '">' . CMTX_COUNTRY_AUSTRALIA  . '</option>
<option value="">---</option>
<option value="' . CMTX_COUNTRY_AFGHANISTAN . '">' . CMTX_COUNTRY_AFGHANISTAN  . '</option>
<option value="' . CMTX_COUNTRY_ALBANIA . '">' . CMTX_COUNTRY_ALBANIA  . '</option>
<option value="' . CMTX_COUNTRY_ALGERIA . '">' . CMTX_COUNTRY_ALGERIA  . '</option>
<option value="' . CMTX_COUNTRY_ANDORRA . '">' . CMTX_COUNTRY_ANDORRA  . '</option>
<option value="' . CMTX_COUNTRY_ANGOLA . '">' . CMTX_COUNTRY_ANGOLA  . '</option>
<option value="' . CMTX_COUNTRY_ANTIGUA . '">' . CMTX_COUNTRY_ANTIGUA  . '</option>
<option value="' . CMTX_COUNTRY_ARGENTINA . '">' . CMTX_COUNTRY_ARGENTINA  . '</option>
<option value="' . CMTX_COUNTRY_ARMENIA . '">' . CMTX_COUNTRY_ARMENIA  . '</option>
<option value="' . CMTX_COUNTRY_ARUBA . '">' . CMTX_COUNTRY_ARUBA  . '</option>
<option value="' . CMTX_COUNTRY_AUSTRIA . '">' . CMTX_COUNTRY_AUSTRIA  . '</option>
<option value="' . CMTX_COUNTRY_AZERBAIJAN . '">' . CMTX_COUNTRY_AZERBAIJAN  . '</option>
<option value="' . CMTX_COUNTRY_BAHAMAS . '">' . CMTX_COUNTRY_BAHAMAS  . '</option>
<option value="' . CMTX_COUNTRY_BAHRAIN . '">' . CMTX_COUNTRY_BAHRAIN  . '</option>
<option value="' . CMTX_COUNTRY_BANGLADESH . '">' . CMTX_COUNTRY_BANGLADESH  . '</option>
<option value="' . CMTX_COUNTRY_BARBADOS . '">' . CMTX_COUNTRY_BARBADOS  . '</option>
<option value="' . CMTX_COUNTRY_BARBUDA . '">' . CMTX_COUNTRY_BARBUDA  . '</option>
<option value="' . CMTX_COUNTRY_BELARUS . '">' . CMTX_COUNTRY_BELARUS  . '</option>
<option value="' . CMTX_COUNTRY_BELGIUM . '">' . CMTX_COUNTRY_BELGIUM  . '</option>
<option value="' . CMTX_COUNTRY_BELIZE . '">' . CMTX_COUNTRY_BELIZE  . '</option>
<option value="' . CMTX_COUNTRY_BENIN . '">' . CMTX_COUNTRY_BENIN  . '</option>
<option value="' . CMTX_COUNTRY_BERMUDA . '">' . CMTX_COUNTRY_BERMUDA  . '</option>
<option value="' . CMTX_COUNTRY_BHUTAN . '">' . CMTX_COUNTRY_BHUTAN  . '</option>
<option value="' . CMTX_COUNTRY_BOLIVIA . '">' . CMTX_COUNTRY_BOLIVIA  . '</option>
<option value="' . CMTX_COUNTRY_BOSNIA . '">' . CMTX_COUNTRY_BOSNIA  . '</option>
<option value="' . CMTX_COUNTRY_BOTSWANA . '">' . CMTX_COUNTRY_BOTSWANA  . '</option>
<option value="' . CMTX_COUNTRY_BRAZIL . '">' . CMTX_COUNTRY_BRAZIL  . '</option>
<option value="' . CMTX_COUNTRY_BRUNEI . '">' . CMTX_COUNTRY_BRUNEI  . '</option>
<option value="' . CMTX_COUNTRY_BULGARIA . '">' . CMTX_COUNTRY_BULGARIA  . '</option>
<option value="' . CMTX_COUNTRY_BURKINA_FASO . '">' . CMTX_COUNTRY_BURKINA_FASO  . '</option>
<option value="' . CMTX_COUNTRY_BURMA . '">' . CMTX_COUNTRY_BURMA  . '</option>
<option value="' . CMTX_COUNTRY_BURUNDI . '">' . CMTX_COUNTRY_BURUNDI  . '</option>
<option value="' . CMTX_COUNTRY_CAMBODIA . '">' . CMTX_COUNTRY_CAMBODIA  . '</option>
<option value="' . CMTX_COUNTRY_CAMEROON . '">' . CMTX_COUNTRY_CAMEROON  . '</option>
<option value="' . CMTX_COUNTRY_CAYMAN_ISLANDS . '">' . CMTX_COUNTRY_CAYMAN_ISLANDS  . '</option>
<option value="' . CMTX_COUNTRY_CENTRAL_AFRICAN_REP . '">' . CMTX_COUNTRY_CENTRAL_AFRICAN_REP  . '</option>
<option value="' . CMTX_COUNTRY_CHAD . '">' . CMTX_COUNTRY_CHAD  . '</option>
<option value="' . CMTX_COUNTRY_CHILE . '">' . CMTX_COUNTRY_CHILE  . '</option>
<option value="' . CMTX_COUNTRY_CHINA . '">' . CMTX_COUNTRY_CHINA  . '</option>
<option value="' . CMTX_COUNTRY_COLOMBIA . '">' . CMTX_COUNTRY_COLOMBIA  . '</option>
<option value="' . CMTX_COUNTRY_CONGO . '">' . CMTX_COUNTRY_CONGO  . '</option>
<option value="' . CMTX_COUNTRY_COSTA_RICA . '">' . CMTX_COUNTRY_COSTA_RICA  . '</option>
<option value="' . CMTX_COUNTRY_CROATIA . '">' . CMTX_COUNTRY_CROATIA  . '</option>
<option value="' . CMTX_COUNTRY_CUBA . '">' . CMTX_COUNTRY_CUBA  . '</option>
<option value="' . CMTX_COUNTRY_CYPRUS . '">' . CMTX_COUNTRY_CYPRUS  . '</option>
<option value="' . CMTX_COUNTRY_CZECH_REPUBLIC . '">' . CMTX_COUNTRY_CZECH_REPUBLIC  . '</option>
<option value="' . CMTX_COUNTRY_DENMARK . '">' . CMTX_COUNTRY_DENMARK  . '</option>
<option value="' . CMTX_COUNTRY_DJIBOUTI . '">' . CMTX_COUNTRY_DJIBOUTI  . '</option>
<option value="' . CMTX_COUNTRY_DOMINICAN_REP . '">' . CMTX_COUNTRY_DOMINICAN_REP  . '</option>
<option value="' . CMTX_COUNTRY_DR_CONGO . '">' . CMTX_COUNTRY_DR_CONGO  . '</option>
<option value="' . CMTX_COUNTRY_ECUADOR . '">' . CMTX_COUNTRY_ECUADOR  . '</option>
<option value="' . CMTX_COUNTRY_EGYPT . '">' . CMTX_COUNTRY_EGYPT  . '</option>
<option value="' . CMTX_COUNTRY_EL_SALVADOR . '">' . CMTX_COUNTRY_EL_SALVADOR  . '</option>
<option value="' . CMTX_COUNTRY_EQUATORIAL_GUINEA . '">' . CMTX_COUNTRY_EQUATORIAL_GUINEA  . '</option>
<option value="' . CMTX_COUNTRY_ERITREA . '">' . CMTX_COUNTRY_ERITREA  . '</option>
<option value="' . CMTX_COUNTRY_ESTONIA . '">' . CMTX_COUNTRY_ESTONIA  . '</option>
<option value="' . CMTX_COUNTRY_ETHIOPIA . '">' . CMTX_COUNTRY_ETHIOPIA  . '</option>
<option value="' . CMTX_COUNTRY_FALKLANDS . '">' . CMTX_COUNTRY_FALKLANDS  . '</option>
<option value="' . CMTX_COUNTRY_FAROE_ISLANDS . '">' . CMTX_COUNTRY_FAROE_ISLANDS  . '</option>
<option value="' . CMTX_COUNTRY_FIJI . '">' . CMTX_COUNTRY_FIJI  . '</option>
<option value="' . CMTX_COUNTRY_FINLAND . '">' . CMTX_COUNTRY_FINLAND  . '</option>
<option value="' . CMTX_COUNTRY_FRANCE . '">' . CMTX_COUNTRY_FRANCE  . '</option>
<option value="' . CMTX_COUNTRY_GABON . '">' . CMTX_COUNTRY_GABON  . '</option>
<option value="' . CMTX_COUNTRY_GAMBIA . '">' . CMTX_COUNTRY_GAMBIA  . '</option>
<option value="' . CMTX_COUNTRY_GEORGIA . '">' . CMTX_COUNTRY_GEORGIA  . '</option>
<option value="' . CMTX_COUNTRY_GERMANY . '">' . CMTX_COUNTRY_GERMANY  . '</option>
<option value="' . CMTX_COUNTRY_GHANA . '">' . CMTX_COUNTRY_GHANA  . '</option>
<option value="' . CMTX_COUNTRY_GREECE . '">' . CMTX_COUNTRY_GREECE  . '</option>
<option value="' . CMTX_COUNTRY_GREENLAND . '">' . CMTX_COUNTRY_GREENLAND  . '</option>
<option value="' . CMTX_COUNTRY_GRENADA . '">' . CMTX_COUNTRY_GRENADA  . '</option>
<option value="' . CMTX_COUNTRY_GUADELOUPE . '">' . CMTX_COUNTRY_GUADELOUPE  . '</option>
<option value="' . CMTX_COUNTRY_GUATEMALA . '">' . CMTX_COUNTRY_GUATEMALA  . '</option>
<option value="' . CMTX_COUNTRY_GUERNSEY . '">' . CMTX_COUNTRY_GUERNSEY  . '</option>
<option value="' . CMTX_COUNTRY_GUINEA . '">' . CMTX_COUNTRY_GUINEA  . '</option>
<option value="' . CMTX_COUNTRY_GUINEA_BISSAU . '">' . CMTX_COUNTRY_GUINEA_BISSAU  . '</option>
<option value="' . CMTX_COUNTRY_GUYANA . '">' . CMTX_COUNTRY_GUYANA  . '</option>
<option value="' . CMTX_COUNTRY_HAITI . '">' . CMTX_COUNTRY_HAITI  . '</option>
<option value="' . CMTX_COUNTRY_HOLLAND . '">' . CMTX_COUNTRY_HOLLAND  . '</option>
<option value="' . CMTX_COUNTRY_HONDURAS . '">' . CMTX_COUNTRY_HONDURAS  . '</option>
<option value="' . CMTX_COUNTRY_HONG_KONG . '">' . CMTX_COUNTRY_HONG_KONG  . '</option>
<option value="' . CMTX_COUNTRY_HUNGARY . '">' . CMTX_COUNTRY_HUNGARY  . '</option>
<option value="' . CMTX_COUNTRY_ICELAND . '">' . CMTX_COUNTRY_ICELAND  . '</option>
<option value="' . CMTX_COUNTRY_INDIA . '">' . CMTX_COUNTRY_INDIA  . '</option>
<option value="' . CMTX_COUNTRY_INDONESIA . '">' . CMTX_COUNTRY_INDONESIA  . '</option>
<option value="' . CMTX_COUNTRY_IRAN . '">' . CMTX_COUNTRY_IRAN  . '</option>
<option value="' . CMTX_COUNTRY_IRAQ . '">' . CMTX_COUNTRY_IRAQ  . '</option>
<option value="' . CMTX_COUNTRY_ISLE_OF_MAN . '">' . CMTX_COUNTRY_ISLE_OF_MAN  . '</option>
<option value="' . CMTX_COUNTRY_ISRAEL . '">' . CMTX_COUNTRY_ISRAEL  . '</option>
<option value="' . CMTX_COUNTRY_ITALY . '">' . CMTX_COUNTRY_ITALY  . '</option>
<option value="' . CMTX_COUNTRY_IVORY_COAST . '">' . CMTX_COUNTRY_IVORY_COAST  . '</option>
<option value="' . CMTX_COUNTRY_JAMAICA . '">' . CMTX_COUNTRY_JAMAICA  . '</option>
<option value="' . CMTX_COUNTRY_JAPAN . '">' . CMTX_COUNTRY_JAPAN  . '</option>
<option value="' . CMTX_COUNTRY_JERSEY . '">' . CMTX_COUNTRY_JERSEY  . '</option>
<option value="' . CMTX_COUNTRY_JORDON . '">' . CMTX_COUNTRY_JORDON  . '</option>
<option value="' . CMTX_COUNTRY_KAZAKHSTAN . '">' . CMTX_COUNTRY_KAZAKHSTAN  . '</option>
<option value="' . CMTX_COUNTRY_KENYA . '">' . CMTX_COUNTRY_KENYA  . '</option>
<option value="' . CMTX_COUNTRY_KUWAIT . '">' . CMTX_COUNTRY_KUWAIT  . '</option>
<option value="' . CMTX_COUNTRY_KYRGYZSTAN . '">' . CMTX_COUNTRY_KYRGYZSTAN  . '</option>
<option value="' . CMTX_COUNTRY_LAOS . '">' . CMTX_COUNTRY_LAOS  . '</option>
<option value="' . CMTX_COUNTRY_LATVIA . '">' . CMTX_COUNTRY_LATVIA  . '</option>
<option value="' . CMTX_COUNTRY_LEBANON . '">' . CMTX_COUNTRY_LEBANON  . '</option>
<option value="' . CMTX_COUNTRY_LESOTHO . '">' . CMTX_COUNTRY_LESOTHO  . '</option>
<option value="' . CMTX_COUNTRY_LIBERIA . '">' . CMTX_COUNTRY_LIBERIA  . '</option>
<option value="' . CMTX_COUNTRY_LIBYA . '">' . CMTX_COUNTRY_LIBYA  . '</option>
<option value="' . CMTX_COUNTRY_LIECHTENSTEIN . '">' . CMTX_COUNTRY_LIECHTENSTEIN  . '</option>
<option value="' . CMTX_COUNTRY_LITHUANIA . '">' . CMTX_COUNTRY_LITHUANIA  . '</option>
<option value="' . CMTX_COUNTRY_LUXEMBOURG . '">' . CMTX_COUNTRY_LUXEMBOURG  . '</option>
<option value="' . CMTX_COUNTRY_MACEDONIA . '">' . CMTX_COUNTRY_MACEDONIA  . '</option>
<option value="' . CMTX_COUNTRY_MADAGASCAR . '">' . CMTX_COUNTRY_MADAGASCAR  . '</option>
<option value="' . CMTX_COUNTRY_MALAWI . '">' . CMTX_COUNTRY_MALAWI  . '</option>
<option value="' . CMTX_COUNTRY_MALAYSIA . '">' . CMTX_COUNTRY_MALAYSIA  . '</option>
<option value="' . CMTX_COUNTRY_MALAYSIA . '">' . CMTX_COUNTRY_MALAYSIA  . '</option>
<option value="' . CMTX_COUNTRY_MALI . '">' . CMTX_COUNTRY_MALI  . '</option>
<option value="' . CMTX_COUNTRY_MALTA . '">' . CMTX_COUNTRY_MALTA  . '</option>
<option value="' . CMTX_COUNTRY_MAURITANIA . '">' . CMTX_COUNTRY_MAURITANIA  . '</option>
<option value="' . CMTX_COUNTRY_MAURITIUS . '">' . CMTX_COUNTRY_MAURITIUS  . '</option>
<option value="' . CMTX_COUNTRY_MEXICO . '">' . CMTX_COUNTRY_MEXICO  . '</option>
<option value="' . CMTX_COUNTRY_MOLDOVA . '">' . CMTX_COUNTRY_MOLDOVA  . '</option>
<option value="' . CMTX_COUNTRY_MONACO . '">' . CMTX_COUNTRY_MONACO  . '</option>
<option value="' . CMTX_COUNTRY_MONGOLIA . '">' . CMTX_COUNTRY_MONGOLIA  . '</option>
<option value="' . CMTX_COUNTRY_MONTENEGRO . '">' . CMTX_COUNTRY_MONTENEGRO  . '</option>
<option value="' . CMTX_COUNTRY_MOROCCO . '">' . CMTX_COUNTRY_MOROCCO  . '</option>
<option value="' . CMTX_COUNTRY_MOZAMBIQUE . '">' . CMTX_COUNTRY_MOZAMBIQUE  . '</option>
<option value="' . CMTX_COUNTRY_NAMIBIA . '">' . CMTX_COUNTRY_NAMIBIA  . '</option>
<option value="' . CMTX_COUNTRY_NEPAL . '">' . CMTX_COUNTRY_NEPAL  . '</option>
<option value="' . CMTX_COUNTRY_NEW_ZEALAND . '">' . CMTX_COUNTRY_NEW_ZEALAND  . '</option>
<option value="' . CMTX_COUNTRY_NICARAGUA . '">' . CMTX_COUNTRY_NICARAGUA  . '</option>
<option value="' . CMTX_COUNTRY_NIGER . '">' . CMTX_COUNTRY_NIGER  . '</option>
<option value="' . CMTX_COUNTRY_NIGERIA . '">' . CMTX_COUNTRY_NIGERIA  . '</option>
<option value="' . CMTX_COUNTRY_NORTH_KOREA . '">' . CMTX_COUNTRY_NORTH_KOREA  . '</option>
<option value="' . CMTX_COUNTRY_NORWAY . '">' . CMTX_COUNTRY_NORWAY  . '</option>
<option value="' . CMTX_COUNTRY_OMAN . '">' . CMTX_COUNTRY_OMAN  . '</option>
<option value="' . CMTX_COUNTRY_PAKISTAN . '">' . CMTX_COUNTRY_PAKISTAN  . '</option>
<option value="' . CMTX_COUNTRY_PALESTINE . '">' . CMTX_COUNTRY_PALESTINE  . '</option>
<option value="' . CMTX_COUNTRY_PANAMA . '">' . CMTX_COUNTRY_PANAMA  . '</option>
<option value="' . CMTX_COUNTRY_PAPUA_NEW_GUINEA . '">' . CMTX_COUNTRY_PAPUA_NEW_GUINEA  . '</option>
<option value="' . CMTX_COUNTRY_PARAGUAY . '">' . CMTX_COUNTRY_PARAGUAY  . '</option>
<option value="' . CMTX_COUNTRY_PERU . '">' . CMTX_COUNTRY_PERU  . '</option>
<option value="' . CMTX_COUNTRY_PHILIPPINES . '">' . CMTX_COUNTRY_PHILIPPINES  . '</option>
<option value="' . CMTX_COUNTRY_POLAND . '">' . CMTX_COUNTRY_POLAND  . '</option>
<option value="' . CMTX_COUNTRY_PORTUGAL . '">' . CMTX_COUNTRY_PORTUGAL  . '</option>
<option value="' . CMTX_COUNTRY_PUERTO_RICO . '">' . CMTX_COUNTRY_PUERTO_RICO  . '</option>
<option value="' . CMTX_COUNTRY_QATAR . '">' . CMTX_COUNTRY_QATAR  . '</option>
<option value="' . CMTX_COUNTRY_ROMANIA . '">' . CMTX_COUNTRY_ROMANIA  . '</option>
<option value="' . CMTX_COUNTRY_RUSSIA . '">' . CMTX_COUNTRY_RUSSIA  . '</option>
<option value="' . CMTX_COUNTRY_RWANDA . '">' . CMTX_COUNTRY_RWANDA  . '</option>
<option value="' . CMTX_COUNTRY_SAMOA . '">' . CMTX_COUNTRY_SAMOA  . '</option>
<option value="' . CMTX_COUNTRY_SAN_MARINO . '">' . CMTX_COUNTRY_SAN_MARINO  . '</option>
<option value="' . CMTX_COUNTRY_SAUDI_ARABIA . '">' . CMTX_COUNTRY_SAUDI_ARABIA  . '</option>
<option value="' . CMTX_COUNTRY_SENEGAL . '">' . CMTX_COUNTRY_SENEGAL  . '</option>
<option value="' . CMTX_COUNTRY_SERBIA . '">' . CMTX_COUNTRY_SERBIA  . '</option>
<option value="' . CMTX_COUNTRY_SEYCHELLES . '">' . CMTX_COUNTRY_SEYCHELLES  . '</option>
<option value="' . CMTX_COUNTRY_SIERRA_LEONE . '">' . CMTX_COUNTRY_SIERRA_LEONE  . '</option>
<option value="' . CMTX_COUNTRY_SINGAPORE . '">' . CMTX_COUNTRY_SINGAPORE  . '</option>
<option value="' . CMTX_COUNTRY_SLOVAKIA . '">' . CMTX_COUNTRY_SLOVAKIA  . '</option>
<option value="' . CMTX_COUNTRY_SLOVENIA . '">' . CMTX_COUNTRY_SLOVENIA  . '</option>
<option value="' . CMTX_COUNTRY_SOMALIA . '">' . CMTX_COUNTRY_SOMALIA  . '</option>
<option value="' . CMTX_COUNTRY_SOUTH_AFRICA . '">' . CMTX_COUNTRY_SOUTH_AFRICA  . '</option>
<option value="' . CMTX_COUNTRY_SOUTH_KOREA . '">' . CMTX_COUNTRY_SOUTH_KOREA  . '</option>
<option value="' . CMTX_COUNTRY_SPAIN . '">' . CMTX_COUNTRY_SPAIN  . '</option>
<option value="' . CMTX_COUNTRY_SRI_LANKA . '">' . CMTX_COUNTRY_SRI_LANKA  . '</option>
<option value="' . CMTX_COUNTRY_SUDAN . '">' . CMTX_COUNTRY_SUDAN  . '</option>
<option value="' . CMTX_COUNTRY_SURINAME . '">' . CMTX_COUNTRY_SURINAME  . '</option>
<option value="' . CMTX_COUNTRY_SWAZILAND . '">' . CMTX_COUNTRY_SWAZILAND  . '</option>
<option value="' . CMTX_COUNTRY_SWEDEN . '">' . CMTX_COUNTRY_SWEDEN  . '</option>
<option value="' . CMTX_COUNTRY_SWITZERLAND . '">' . CMTX_COUNTRY_SWITZERLAND  . '</option>
<option value="' . CMTX_COUNTRY_SYRIA . '">' . CMTX_COUNTRY_SYRIA  . '</option>
<option value="' . CMTX_COUNTRY_TAIWAN . '">' . CMTX_COUNTRY_TAIWAN  . '</option>
<option value="' . CMTX_COUNTRY_TAJIKISTAN . '">' . CMTX_COUNTRY_TAJIKISTAN  . '</option>
<option value="' . CMTX_COUNTRY_TANZANIA . '">' . CMTX_COUNTRY_TANZANIA  . '</option>
<option value="' . CMTX_COUNTRY_THAILAND . '">' . CMTX_COUNTRY_THAILAND  . '</option>
<option value="' . CMTX_COUNTRY_THE_EMIRATES . '">' . CMTX_COUNTRY_THE_EMIRATES  . '</option>
<option value="' . CMTX_COUNTRY_TOGO . '">' . CMTX_COUNTRY_TOGO  . '</option>
<option value="' . CMTX_COUNTRY_TRINIDAD_TOBAGO . '">' . CMTX_COUNTRY_TRINIDAD_TOBAGO  . '</option>
<option value="' . CMTX_COUNTRY_TUNISIA . '">' . CMTX_COUNTRY_TUNISIA  . '</option>
<option value="' . CMTX_COUNTRY_TURKEY . '">' . CMTX_COUNTRY_TURKEY  . '</option>
<option value="' . CMTX_COUNTRY_TURKMENISTAN . '">' . CMTX_COUNTRY_TURKMENISTAN  . '</option>
<option value="' . CMTX_COUNTRY_UGANDA . '">' . CMTX_COUNTRY_UGANDA  . '</option>
<option value="' . CMTX_COUNTRY_UKRAINE . '">' . CMTX_COUNTRY_UKRAINE  . '</option>
<option value="' . CMTX_COUNTRY_URUGUAY . '">' . CMTX_COUNTRY_URUGUAY  . '</option>
<option value="' . CMTX_COUNTRY_UZBEKISTAN . '">' . CMTX_COUNTRY_UZBEKISTAN  . '</option>
<option value="' . CMTX_COUNTRY_VATICAN_CITY . '">' . CMTX_COUNTRY_VATICAN_CITY  . '</option>
<option value="' . CMTX_COUNTRY_VENEZUELA . '">' . CMTX_COUNTRY_VENEZUELA  . '</option>
<option value="' . CMTX_COUNTRY_VIETNAM . '">' . CMTX_COUNTRY_VIETNAM  . '</option>
<option value="' . CMTX_COUNTRY_WESTERN_SAHARA . '">' . CMTX_COUNTRY_WESTERN_SAHARA  . '</option>
<option value="' . CMTX_COUNTRY_YEMEN . '">' . CMTX_COUNTRY_YEMEN  . '</option>
<option value="' . CMTX_COUNTRY_ZAMBIA . '">' . CMTX_COUNTRY_ZAMBIA  . '</option>
<option value="' . CMTX_COUNTRY_ZIMBABWE . '">' . CMTX_COUNTRY_ZIMBABWE  . '</option>
</select>';

?>