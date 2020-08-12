<?php


Route::get('/', function () {
    return view('welcome');
});
Route::any('/tester', function (\Illuminate\Http\Request $request) {
    $timezones = '
[
  {
    "value": "Dateline Standard Time",
    "abbr": "DST",
    "offset": -12,
    "isdst": false,
    "text": "(UTC-12:00) International Date Line West",
    "utc": [
      "Etc/GMT+12"
    ]
  },
  {
    "value": "UTC-11",
    "abbr": "U",
    "offset": -11,
    "isdst": false,
    "text": "(UTC-11:00) Coordinated Universal Time-11",
    "utc": [
      "Etc/GMT+11",
      "Pacific/Midway",
      "Pacific/Niue",
      "Pacific/Pago_Pago"
    ]
  },
  {
    "value": "Hawaiian Standard Time",
    "abbr": "HST",
    "offset": -10,
    "isdst": false,
    "text": "(UTC-10:00) Hawaii",
    "utc": [
      "Etc/GMT+10",
      "Pacific/Honolulu",
      "Pacific/Johnston",
      "Pacific/Rarotonga",
      "Pacific/Tahiti"
    ]
  },
  {
    "value": "Alaskan Standard Time",
    "abbr": "AKDT",
    "offset": -8,
    "isdst": true,
    "text": "(UTC-09:00) Alaska",
    "utc": [
      "America/Anchorage",
      "America/Juneau",
      "America/Nome",
      "America/Sitka",
      "America/Yakutat"
    ]
  },
  {
    "value": "Pacific Standard Time (Mexico)",
    "abbr": "PDT",
    "offset": -7,
    "isdst": true,
    "text": "(UTC-08:00) Baja California",
    "utc": [
      "America/Santa_Isabel"
    ]
  },
  {
    "value": "Pacific Daylight Time",
    "abbr": "PDT",
    "offset": -7,
    "isdst": true,
    "text": "(UTC-07:00) Pacific Time (US & Canada)",
    "utc": [
      "America/Dawson",
      "America/Los_Angeles",
      "America/Tijuana",
      "America/Vancouver",
      "America/Whitehorse"
    ]
  },
  {
    "value": "Pacific Standard Time",
    "abbr": "PST",
    "offset": -8,
    "isdst": false,
    "text": "(UTC-08:00) Pacific Time (US & Canada)",
    "utc": [
      "America/Dawson",
      "America/Los_Angeles",
      "America/Tijuana",
      "America/Vancouver",
      "America/Whitehorse",
      "PST8PDT"
    ]
  },
  {
    "value": "US Mountain Standard Time",
    "abbr": "UMST",
    "offset": -7,
    "isdst": false,
    "text": "(UTC-07:00) Arizona",
    "utc": [
      "America/Creston",
      "America/Dawson_Creek",
      "America/Hermosillo",
      "America/Phoenix",
      "Etc/GMT+7"
    ]
  },
  {
    "value": "Mountain Standard Time (Mexico)",
    "abbr": "MDT",
    "offset": -6,
    "isdst": true,
    "text": "(UTC-07:00) Chihuahua, La Paz, Mazatlan",
    "utc": [
      "America/Chihuahua",
      "America/Mazatlan"
    ]
  },
  {
    "value": "Mountain Standard Time",
    "abbr": "MDT",
    "offset": -6,
    "isdst": true,
    "text": "(UTC-07:00) Mountain Time (US & Canada)",
    "utc": [
      "America/Boise",
      "America/Cambridge_Bay",
      "America/Denver",
      "America/Edmonton",
      "America/Inuvik",
      "America/Ojinaga",
      "America/Yellowknife",
      "MST7MDT"
    ]
  },
  {
    "value": "Central America Standard Time",
    "abbr": "CAST",
    "offset": -6,
    "isdst": false,
    "text": "(UTC-06:00) Central America",
    "utc": [
      "America/Belize",
      "America/Costa_Rica",
      "America/El_Salvador",
      "America/Guatemala",
      "America/Managua",
      "America/Tegucigalpa",
      "Etc/GMT+6",
      "Pacific/Galapagos"
    ]
  },
  {
    "value": "Central Standard Time",
    "abbr": "CDT",
    "offset": -5,
    "isdst": true,
    "text": "(UTC-06:00) Central Time (US & Canada)",
    "utc": [
      "America/Chicago",
      "America/Indiana/Knox",
      "America/Indiana/Tell_City",
      "America/Matamoros",
      "America/Menominee",
      "America/North_Dakota/Beulah",
      "America/North_Dakota/Center",
      "America/North_Dakota/New_Salem",
      "America/Rainy_River",
      "America/Rankin_Inlet",
      "America/Resolute",
      "America/Winnipeg",
      "CST6CDT"
    ]
  },
  {
    "value": "Central Standard Time (Mexico)",
    "abbr": "CDT",
    "offset": -5,
    "isdst": true,
    "text": "(UTC-06:00) Guadalajara, Mexico City, Monterrey",
    "utc": [
      "America/Bahia_Banderas",
      "America/Cancun",
      "America/Merida",
      "America/Mexico_City",
      "America/Monterrey"
    ]
  },
  {
    "value": "Canada Central Standard Time",
    "abbr": "CCST",
    "offset": -6,
    "isdst": false,
    "text": "(UTC-06:00) Saskatchewan",
    "utc": [
      "America/Regina",
      "America/Swift_Current"
    ]
  },
  {
    "value": "SA Pacific Standard Time",
    "abbr": "SPST",
    "offset": -5,
    "isdst": false,
    "text": "(UTC-05:00) Bogota, Lima, Quito",
    "utc": [
      "America/Bogota",
      "America/Cayman",
      "America/Coral_Harbour",
      "America/Eirunepe",
      "America/Guayaquil",
      "America/Jamaica",
      "America/Lima",
      "America/Panama",
      "America/Rio_Branco",
      "Etc/GMT+5"
    ]
  },
  {
    "value": "Eastern Standard Time",
    "abbr": "EDT",
    "offset": -4,
    "isdst": true,
    "text": "(UTC-05:00) Eastern Time (US & Canada)",
    "utc": [
      "America/Detroit",
      "America/Havana",
      "America/Indiana/Petersburg",
      "America/Indiana/Vincennes",
      "America/Indiana/Winamac",
      "America/Iqaluit",
      "America/Kentucky/Monticello",
      "America/Louisville",
      "America/Montreal",
      "America/Nassau",
      "America/New_York",
      "America/Nipigon",
      "America/Pangnirtung",
      "America/Port-au-Prince",
      "America/Thunder_Bay",
      "America/Toronto",
      "EST5EDT"
    ]
  },
  {
    "value": "US Eastern Standard Time",
    "abbr": "UEDT",
    "offset": -4,
    "isdst": true,
    "text": "(UTC-05:00) Indiana (East)",
    "utc": [
      "America/Indiana/Marengo",
      "America/Indiana/Vevay",
      "America/Indianapolis"
    ]
  },
  {
    "value": "Venezuela Standard Time",
    "abbr": "VST",
    "offset": -4.5,
    "isdst": false,
    "text": "(UTC-04:30) Caracas",
    "utc": [
      "America/Caracas"
    ]
  },
  {
    "value": "Paraguay Standard Time",
    "abbr": "PYT",
    "offset": -4,
    "isdst": false,
    "text": "(UTC-04:00) Asuncion",
    "utc": [
      "America/Asuncion"
    ]
  },
  {
    "value": "Atlantic Standard Time",
    "abbr": "ADT",
    "offset": -3,
    "isdst": true,
    "text": "(UTC-04:00) Atlantic Time (Canada)",
    "utc": [
      "America/Glace_Bay",
      "America/Goose_Bay",
      "America/Halifax",
      "America/Moncton",
      "America/Thule",
      "Atlantic/Bermuda"
    ]
  },
  {
    "value": "Central Brazilian Standard Time",
    "abbr": "CBST",
    "offset": -4,
    "isdst": false,
    "text": "(UTC-04:00) Cuiaba",
    "utc": [
      "America/Campo_Grande",
      "America/Cuiaba"
    ]
  },
  {
    "value": "SA Western Standard Time",
    "abbr": "SWST",
    "offset": -4,
    "isdst": false,
    "text": "(UTC-04:00) Georgetown, La Paz, Manaus, San Juan",
    "utc": [
      "America/Anguilla",
      "America/Antigua",
      "America/Aruba",
      "America/Barbados",
      "America/Blanc-Sablon",
      "America/Boa_Vista",
      "America/Curacao",
      "America/Dominica",
      "America/Grand_Turk",
      "America/Grenada",
      "America/Guadeloupe",
      "America/Guyana",
      "America/Kralendijk",
      "America/La_Paz",
      "America/Lower_Princes",
      "America/Manaus",
      "America/Marigot",
      "America/Martinique",
      "America/Montserrat",
      "America/Port_of_Spain",
      "America/Porto_Velho",
      "America/Puerto_Rico",
      "America/Santo_Domingo",
      "America/St_Barthelemy",
      "America/St_Kitts",
      "America/St_Lucia",
      "America/St_Thomas",
      "America/St_Vincent",
      "America/Tortola",
      "Etc/GMT+4"
    ]
  },
  {
    "value": "Pacific SA Standard Time",
    "abbr": "PSST",
    "offset": -4,
    "isdst": false,
    "text": "(UTC-04:00) Santiago",
    "utc": [
      "America/Santiago",
      "Antarctica/Palmer"
    ]
  },
  {
    "value": "Newfoundland Standard Time",
    "abbr": "NDT",
    "offset": -2.5,
    "isdst": true,
    "text": "(UTC-03:30) Newfoundland",
    "utc": [
      "America/St_Johns"
    ]
  },
  {
    "value": "E. South America Standard Time",
    "abbr": "ESAST",
    "offset": -3,
    "isdst": false,
    "text": "(UTC-03:00) Brasilia",
    "utc": [
      "America/Sao_Paulo"
    ]
  },
  {
    "value": "Argentina Standard Time",
    "abbr": "AST",
    "offset": -3,
    "isdst": false,
    "text": "(UTC-03:00) Buenos Aires",
    "utc": [
      "America/Argentina/La_Rioja",
      "America/Argentina/Rio_Gallegos",
      "America/Argentina/Salta",
      "America/Argentina/San_Juan",
      "America/Argentina/San_Luis",
      "America/Argentina/Tucuman",
      "America/Argentina/Ushuaia",
      "America/Buenos_Aires",
      "America/Catamarca",
      "America/Cordoba",
      "America/Jujuy",
      "America/Mendoza"
    ]
  },
  {
    "value": "SA Eastern Standard Time",
    "abbr": "SEST",
    "offset": -3,
    "isdst": false,
    "text": "(UTC-03:00) Cayenne, Fortaleza",
    "utc": [
      "America/Araguaina",
      "America/Belem",
      "America/Cayenne",
      "America/Fortaleza",
      "America/Maceio",
      "America/Paramaribo",
      "America/Recife",
      "America/Santarem",
      "Antarctica/Rothera",
      "Atlantic/Stanley",
      "Etc/GMT+3"
    ]
  },
  {
    "value": "Greenland Standard Time",
    "abbr": "GDT",
    "offset": -3,
    "isdst": true,
    "text": "(UTC-03:00) Greenland",
    "utc": [
      "America/Godthab"
    ]
  },
  {
    "value": "Montevideo Standard Time",
    "abbr": "MST",
    "offset": -3,
    "isdst": false,
    "text": "(UTC-03:00) Montevideo",
    "utc": [
      "America/Montevideo"
    ]
  },
  {
    "value": "Bahia Standard Time",
    "abbr": "BST",
    "offset": -3,
    "isdst": false,
    "text": "(UTC-03:00) Salvador",
    "utc": [
      "America/Bahia"
    ]
  },
  {
    "value": "UTC-02",
    "abbr": "U",
    "offset": -2,
    "isdst": false,
    "text": "(UTC-02:00) Coordinated Universal Time-02",
    "utc": [
      "America/Noronha",
      "Atlantic/South_Georgia",
      "Etc/GMT+2"
    ]
  },
  {
    "value": "Mid-Atlantic Standard Time",
    "abbr": "MDT",
    "offset": -1,
    "isdst": true,
    "text": "(UTC-02:00) Mid-Atlantic - Old",
    "utc": []
  },
  {
    "value": "Azores Standard Time",
    "abbr": "ADT",
    "offset": 0,
    "isdst": true,
    "text": "(UTC-01:00) Azores",
    "utc": [
      "America/Scoresbysund",
      "Atlantic/Azores"
    ]
  },
  {
    "value": "Cape Verde Standard Time",
    "abbr": "CVST",
    "offset": -1,
    "isdst": false,
    "text": "(UTC-01:00) Cape Verde Is.",
    "utc": [
      "Atlantic/Cape_Verde",
      "Etc/GMT+1"
    ]
  },
  {
    "value": "Morocco Standard Time",
    "abbr": "MDT",
    "offset": 1,
    "isdst": true,
    "text": "(UTC) Casablanca",
    "utc": [
      "Africa/Casablanca",
      "Africa/El_Aaiun"
    ]
  },
  {
    "value": "UTC",
    "abbr": "UTC",
    "offset": 0,
    "isdst": false,
    "text": "(UTC) Coordinated Universal Time",
    "utc": [
      "America/Danmarkshavn",
      "Etc/GMT"
    ]
  },
  {
    "value": "GMT Standard Time",
    "abbr": "GMT",
    "offset": 0,
    "isdst": false,
    "text": "(UTC) Edinburgh, London",
    "utc": [
      "Europe/Isle_of_Man",
      "Europe/Guernsey",
      "Europe/Jersey",
      "Europe/London"
    ]
  },
  {
    "value": "British Summer Time",
    "abbr": "BST",
    "offset": 1,
    "isdst": true,
    "text": "(UTC+01:00) Edinburgh, London",
    "utc": [
      "Europe/Isle_of_Man",
      "Europe/Guernsey",
      "Europe/Jersey",
      "Europe/London"
    ]
  },
  {
    "value": "GMT Standard Time",
    "abbr": "GDT",
    "offset": 1,
    "isdst": true,
    "text": "(UTC) Dublin, Lisbon",
    "utc": [
      "Atlantic/Canary",
      "Atlantic/Faeroe",
      "Atlantic/Madeira",
      "Europe/Dublin",
      "Europe/Lisbon"
    ]
  },
  {
    "value": "Greenwich Standard Time",
    "abbr": "GST",
    "offset": 0,
    "isdst": false,
    "text": "(UTC) Monrovia, Reykjavik",
    "utc": [
      "Africa/Abidjan",
      "Africa/Accra",
      "Africa/Bamako",
      "Africa/Banjul",
      "Africa/Bissau",
      "Africa/Conakry",
      "Africa/Dakar",
      "Africa/Freetown",
      "Africa/Lome",
      "Africa/Monrovia",
      "Africa/Nouakchott",
      "Africa/Ouagadougou",
      "Africa/Sao_Tome",
      "Atlantic/Reykjavik",
      "Atlantic/St_Helena"
    ]
  },
  {
    "value": "W. Europe Standard Time",
    "abbr": "WEDT",
    "offset": 2,
    "isdst": true,
    "text": "(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
    "utc": [
      "Arctic/Longyearbyen",
      "Europe/Amsterdam",
      "Europe/Andorra",
      "Europe/Berlin",
      "Europe/Busingen",
      "Europe/Gibraltar",
      "Europe/Luxembourg",
      "Europe/Malta",
      "Europe/Monaco",
      "Europe/Oslo",
      "Europe/Rome",
      "Europe/San_Marino",
      "Europe/Stockholm",
      "Europe/Vaduz",
      "Europe/Vatican",
      "Europe/Vienna",
      "Europe/Zurich"
    ]
  },
  {
    "value": "Central Europe Standard Time",
    "abbr": "CEDT",
    "offset": 2,
    "isdst": true,
    "text": "(UTC+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
    "utc": [
      "Europe/Belgrade",
      "Europe/Bratislava",
      "Europe/Budapest",
      "Europe/Ljubljana",
      "Europe/Podgorica",
      "Europe/Prague",
      "Europe/Tirane"
    ]
  },
  {
    "value": "Romance Standard Time",
    "abbr": "RDT",
    "offset": 2,
    "isdst": true,
    "text": "(UTC+01:00) Brussels, Copenhagen, Madrid, Paris",
    "utc": [
      "Africa/Ceuta",
      "Europe/Brussels",
      "Europe/Copenhagen",
      "Europe/Madrid",
      "Europe/Paris"
    ]
  },
  {
    "value": "Central European Standard Time",
    "abbr": "CEDT",
    "offset": 2,
    "isdst": true,
    "text": "(UTC+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
    "utc": [
      "Europe/Sarajevo",
      "Europe/Skopje",
      "Europe/Warsaw",
      "Europe/Zagreb"
    ]
  },
  {
    "value": "W. Central Africa Standard Time",
    "abbr": "WCAST",
    "offset": 1,
    "isdst": false,
    "text": "(UTC+01:00) West Central Africa",
    "utc": [
      "Africa/Algiers",
      "Africa/Bangui",
      "Africa/Brazzaville",
      "Africa/Douala",
      "Africa/Kinshasa",
      "Africa/Lagos",
      "Africa/Libreville",
      "Africa/Luanda",
      "Africa/Malabo",
      "Africa/Ndjamena",
      "Africa/Niamey",
      "Africa/Porto-Novo",
      "Africa/Tunis",
      "Etc/GMT-1"
    ]
  },
  {
    "value": "Namibia Standard Time",
    "abbr": "NST",
    "offset": 1,
    "isdst": false,
    "text": "(UTC+01:00) Windhoek",
    "utc": [
      "Africa/Windhoek"
    ]
  },
  {
    "value": "GTB Standard Time",
    "abbr": "GDT",
    "offset": 3,
    "isdst": true,
    "text": "(UTC+02:00) Athens, Bucharest",
    "utc": [
      "Asia/Nicosia",
      "Europe/Athens",
      "Europe/Bucharest",
      "Europe/Chisinau"
    ]
  },
  {
    "value": "Middle East Standard Time",
    "abbr": "MEDT",
    "offset": 3,
    "isdst": true,
    "text": "(UTC+02:00) Beirut",
    "utc": [
      "Asia/Beirut"
    ]
  },
  {
    "value": "Egypt Standard Time",
    "abbr": "EST",
    "offset": 2,
    "isdst": false,
    "text": "(UTC+02:00) Cairo",
    "utc": [
      "Africa/Cairo"
    ]
  },
  {
    "value": "Syria Standard Time",
    "abbr": "SDT",
    "offset": 3,
    "isdst": true,
    "text": "(UTC+02:00) Damascus",
    "utc": [
      "Asia/Damascus"
    ]
  },
  {
    "value": "E. Europe Standard Time",
    "abbr": "EEDT",
    "offset": 3,
    "isdst": true,
    "text": "(UTC+02:00) E. Europe",
    "utc": [
      "Asia/Nicosia",
      "Europe/Athens",
      "Europe/Bucharest",
      "Europe/Chisinau",
      "Europe/Helsinki",
      "Europe/Kiev",
      "Europe/Mariehamn",
      "Europe/Nicosia",
      "Europe/Riga",
      "Europe/Sofia",
      "Europe/Tallinn",
      "Europe/Uzhgorod",
      "Europe/Vilnius",
      "Europe/Zaporozhye"

    ]
  },
  {
    "value": "South Africa Standard Time",
    "abbr": "SAST",
    "offset": 2,
    "isdst": false,
    "text": "(UTC+02:00) Harare, Pretoria",
    "utc": [
      "Africa/Blantyre",
      "Africa/Bujumbura",
      "Africa/Gaborone",
      "Africa/Harare",
      "Africa/Johannesburg",
      "Africa/Kigali",
      "Africa/Lubumbashi",
      "Africa/Lusaka",
      "Africa/Maputo",
      "Africa/Maseru",
      "Africa/Mbabane",
      "Etc/GMT-2"
    ]
  },
  {
    "value": "FLE Standard Time",
    "abbr": "FDT",
    "offset": 3,
    "isdst": true,
    "text": "(UTC+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
    "utc": [
      "Europe/Helsinki",
      "Europe/Kiev",
      "Europe/Mariehamn",
      "Europe/Riga",
      "Europe/Sofia",
      "Europe/Tallinn",
      "Europe/Uzhgorod",
      "Europe/Vilnius",
      "Europe/Zaporozhye"
    ]
  },
  {
    "value": "Turkey Standard Time",
    "abbr": "TDT",
    "offset": 3,
    "isdst": false,
    "text": "(UTC+03:00) Istanbul",
    "utc": [
      "Europe/Istanbul"
    ]
  },
  {
    "value": "Israel Standard Time",
    "abbr": "JDT",
    "offset": 3,
    "isdst": true,
    "text": "(UTC+02:00) Jerusalem",
    "utc": [
      "Asia/Jerusalem"
    ]
  },
  {
    "value": "Libya Standard Time",
    "abbr": "LST",
    "offset": 2,
    "isdst": false,
    "text": "(UTC+02:00) Tripoli",
    "utc": [
      "Africa/Tripoli"
    ]
  },
  {
    "value": "Jordan Standard Time",
    "abbr": "JST",
    "offset": 3,
    "isdst": false,
    "text": "(UTC+03:00) Amman",
    "utc": [
      "Asia/Amman"
    ]
  },
  {
    "value": "Arabic Standard Time",
    "abbr": "AST",
    "offset": 3,
    "isdst": false,
    "text": "(UTC+03:00) Baghdad",
    "utc": [
      "Asia/Baghdad"
    ]
  },
  {
    "value": "Kaliningrad Standard Time",
    "abbr": "KST",
    "offset": 3,
    "isdst": false,
    "text": "(UTC+03:00) Kaliningrad, Minsk",
    "utc": [
      "Europe/Kaliningrad",
      "Europe/Minsk"
    ]
  },
  {
    "value": "Arab Standard Time",
    "abbr": "AST",
    "offset": 3,
    "isdst": false,
    "text": "(UTC+03:00) Kuwait, Riyadh",
    "utc": [
      "Asia/Aden",
      "Asia/Bahrain",
      "Asia/Kuwait",
      "Asia/Qatar",
      "Asia/Riyadh"
    ]
  },
  {
    "value": "E. Africa Standard Time",
    "abbr": "EAST",
    "offset": 3,
    "isdst": false,
    "text": "(UTC+03:00) Nairobi",
    "utc": [
      "Africa/Addis_Ababa",
      "Africa/Asmera",
      "Africa/Dar_es_Salaam",
      "Africa/Djibouti",
      "Africa/Juba",
      "Africa/Kampala",
      "Africa/Khartoum",
      "Africa/Mogadishu",
      "Africa/Nairobi",
      "Antarctica/Syowa",
      "Etc/GMT-3",
      "Indian/Antananarivo",
      "Indian/Comoro",
      "Indian/Mayotte"
    ]
  },
  {
    "value": "Moscow Standard Time",
    "abbr": "MSK",
    "offset": 3,
    "isdst": false,
    "text": "(UTC+03:00) Moscow, St. Petersburg, Volgograd",
    "utc": [
	    "Europe/Kirov",
      "Europe/Moscow",
      "Europe/Simferopol",
      "Europe/Volgograd"
    ]
  },
  {
    "value": "Samara Time",
    "abbr": "SAMT",
    "offset": 4,
    "isdst": false,
    "text": "(UTC+04:00) Samara, Ulyanovsk, Saratov",
    "utc": [
	    "Europe/Astrakhan",
      "Europe/Samara",
	    "Europe/Ulyanovsk"
    ]
  },
  {
    "value": "Iran Standard Time",
    "abbr": "IDT",
    "offset": 4.5,
    "isdst": true,
    "text": "(UTC+03:30) Tehran",
    "utc": [
      "Asia/Tehran"
    ]
  },
  {
    "value": "Arabian Standard Time",
    "abbr": "AST",
    "offset": 4,
    "isdst": false,
    "text": "(UTC+04:00) Abu Dhabi, Muscat",
    "utc": [
      "Asia/Dubai",
      "Asia/Muscat",
      "Etc/GMT-4"
    ]
  },
  {
    "value": "Azerbaijan Standard Time",
    "abbr": "ADT",
    "offset": 5,
    "isdst": true,
    "text": "(UTC+04:00) Baku",
    "utc": [
      "Asia/Baku"
    ]
  },
  {
    "value": "Mauritius Standard Time",
    "abbr": "MST",
    "offset": 4,
    "isdst": false,
    "text": "(UTC+04:00) Port Louis",
    "utc": [
      "Indian/Mahe",
      "Indian/Mauritius",
      "Indian/Reunion"
    ]
  },
  {
    "value": "Georgian Standard Time",
    "abbr": "GET",
    "offset": 4,
    "isdst": false,
    "text": "(UTC+04:00) Tbilisi",
    "utc": [
      "Asia/Tbilisi"
    ]
  },
  {
    "value": "Caucasus Standard Time",
    "abbr": "CST",
    "offset": 4,
    "isdst": false,
    "text": "(UTC+04:00) Yerevan",
    "utc": [
      "Asia/Yerevan"
    ]
  },
  {
    "value": "Afghanistan Standard Time",
    "abbr": "AST",
    "offset": 4.5,
    "isdst": false,
    "text": "(UTC+04:30) Kabul",
    "utc": [
      "Asia/Kabul"
    ]
  },
  {
    "value": "West Asia Standard Time",
    "abbr": "WAST",
    "offset": 5,
    "isdst": false,
    "text": "(UTC+05:00) Ashgabat, Tashkent",
    "utc": [
      "Antarctica/Mawson",
      "Asia/Aqtau",
      "Asia/Aqtobe",
      "Asia/Ashgabat",
      "Asia/Dushanbe",
      "Asia/Oral",
      "Asia/Samarkand",
      "Asia/Tashkent",
      "Etc/GMT-5",
      "Indian/Kerguelen",
      "Indian/Maldives"
    ]
  },
  {
    "value": "Yekaterinburg Time",
    "abbr": "YEKT",
    "offset": 5,
    "isdst": false,
    "text": "(UTC+05:00) Yekaterinburg",
    "utc": [
      "Asia/Yekaterinburg"
    ]
  },
  {
    "value": "Pakistan Standard Time",
    "abbr": "PKT",
    "offset": 5,
    "isdst": false,
    "text": "(UTC+05:00) Islamabad, Karachi",
    "utc": [
      "Asia/Karachi"
    ]
  },
  {
    "value": "India Standard Time",
    "abbr": "IST",
    "offset": 5.5,
    "isdst": false,
    "text": "(UTC+05:30) Chennai, Kolkata, Mumbai, New Delhi",
    "utc": [
      "Asia/Kolkata"
    ]
  },
  {
    "value": "Sri Lanka Standard Time",
    "abbr": "SLST",
    "offset": 5.5,
    "isdst": false,
    "text": "(UTC+05:30) Sri Jayawardenepura",
    "utc": [
      "Asia/Colombo"
    ]
  },
  {
    "value": "Nepal Standard Time",
    "abbr": "NST",
    "offset": 5.75,
    "isdst": false,
    "text": "(UTC+05:45) Kathmandu",
    "utc": [
      "Asia/Kathmandu"
    ]
  },
  {
    "value": "Central Asia Standard Time",
    "abbr": "CAST",
    "offset": 6,
    "isdst": false,
    "text": "(UTC+06:00) Astana",
    "utc": [
      "Antarctica/Vostok",
      "Asia/Almaty",
      "Asia/Bishkek",
      "Asia/Qyzylorda",
      "Asia/Urumqi",
      "Etc/GMT-6",
      "Indian/Chagos"
    ]
  },
  {
    "value": "Bangladesh Standard Time",
    "abbr": "BST",
    "offset": 6,
    "isdst": false,
    "text": "(UTC+06:00) Dhaka",
    "utc": [
      "Asia/Dhaka",
      "Asia/Thimphu"
    ]
  },
  {
    "value": "Myanmar Standard Time",
    "abbr": "MST",
    "offset": 6.5,
    "isdst": false,
    "text": "(UTC+06:30) Yangon (Rangoon)",
    "utc": [
      "Asia/Rangoon",
      "Indian/Cocos"
    ]
  },
  {
    "value": "SE Asia Standard Time",
    "abbr": "SAST",
    "offset": 7,
    "isdst": false,
    "text": "(UTC+07:00) Bangkok, Hanoi, Jakarta",
    "utc": [
      "Antarctica/Davis",
      "Asia/Bangkok",
      "Asia/Hovd",
      "Asia/Jakarta",
      "Asia/Phnom_Penh",
      "Asia/Pontianak",
      "Asia/Saigon",
      "Asia/Vientiane",
      "Etc/GMT-7",
      "Indian/Christmas"
    ]
  },
  {
    "value": "N. Central Asia Standard Time",
    "abbr": "NCAST",
    "offset": 7,
    "isdst": false,
    "text": "(UTC+07:00) Novosibirsk",
    "utc": [
      "Asia/Novokuznetsk",
      "Asia/Novosibirsk",
      "Asia/Omsk"
    ]
  },
  {
    "value": "China Standard Time",
    "abbr": "CST",
    "offset": 8,
    "isdst": false,
    "text": "(UTC+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
    "utc": [
      "Asia/Hong_Kong",
      "Asia/Macau",
      "Asia/Shanghai"
    ]
  },
  {
    "value": "North Asia Standard Time",
    "abbr": "NAST",
    "offset": 8,
    "isdst": false,
    "text": "(UTC+08:00) Krasnoyarsk",
    "utc": [
      "Asia/Krasnoyarsk"
    ]
  },
  {
    "value": "Singapore Standard Time",
    "abbr": "MPST",
    "offset": 8,
    "isdst": false,
    "text": "(UTC+08:00) Kuala Lumpur, Singapore",
    "utc": [
      "Asia/Brunei",
      "Asia/Kuala_Lumpur",
      "Asia/Kuching",
      "Asia/Makassar",
      "Asia/Manila",
      "Asia/Singapore",
      "Etc/GMT-8"
    ]
  },
  {
    "value": "W. Australia Standard Time",
    "abbr": "WAST",
    "offset": 8,
    "isdst": false,
    "text": "(UTC+08:00) Perth",
    "utc": [
      "Antarctica/Casey",
      "Australia/Perth"
    ]
  },
  {
    "value": "Taipei Standard Time",
    "abbr": "TST",
    "offset": 8,
    "isdst": false,
    "text": "(UTC+08:00) Taipei",
    "utc": [
      "Asia/Taipei"
    ]
  },
  {
    "value": "Ulaanbaatar Standard Time",
    "abbr": "UST",
    "offset": 8,
    "isdst": false,
    "text": "(UTC+08:00) Ulaanbaatar",
    "utc": [
      "Asia/Choibalsan",
      "Asia/Ulaanbaatar"
    ]
  },
  {
    "value": "North Asia East Standard Time",
    "abbr": "NAEST",
    "offset": 8,
    "isdst": false,
    "text": "(UTC+08:00) Irkutsk",
    "utc": [
      "Asia/Irkutsk"
    ]
  },
  {
    "value": "Japan Standard Time",
    "abbr": "JST",
    "offset": 9,
    "isdst": false,
    "text": "(UTC+09:00) Osaka, Sapporo, Tokyo",
    "utc": [
      "Asia/Dili",
      "Asia/Jayapura",
      "Asia/Tokyo",
      "Etc/GMT-9",
      "Pacific/Palau"
    ]
  },
  {
    "value": "Korea Standard Time",
    "abbr": "KST",
    "offset": 9,
    "isdst": false,
    "text": "(UTC+09:00) Seoul",
    "utc": [
      "Asia/Pyongyang",
      "Asia/Seoul"
    ]
  },
  {
    "value": "Cen. Australia Standard Time",
    "abbr": "CAST",
    "offset": 9.5,
    "isdst": false,
    "text": "(UTC+09:30) Adelaide",
    "utc": [
      "Australia/Adelaide",
      "Australia/Broken_Hill"
    ]
  },
  {
    "value": "AUS Central Standard Time",
    "abbr": "ACST",
    "offset": 9.5,
    "isdst": false,
    "text": "(UTC+09:30) Darwin",
    "utc": [
      "Australia/Darwin"
    ]
  },
  {
    "value": "E. Australia Standard Time",
    "abbr": "EAST",
    "offset": 10,
    "isdst": false,
    "text": "(UTC+10:00) Brisbane",
    "utc": [
      "Australia/Brisbane",
      "Australia/Lindeman"
    ]
  },
  {
    "value": "AUS Eastern Standard Time",
    "abbr": "AEST",
    "offset": 10,
    "isdst": false,
    "text": "(UTC+10:00) Canberra, Melbourne, Sydney",
    "utc": [
      "Australia/Melbourne",
      "Australia/Sydney"
    ]
  },
  {
    "value": "West Pacific Standard Time",
    "abbr": "WPST",
    "offset": 10,
    "isdst": false,
    "text": "(UTC+10:00) Guam, Port Moresby",
    "utc": [
      "Antarctica/DumontDUrville",
      "Etc/GMT-10",
      "Pacific/Guam",
      "Pacific/Port_Moresby",
      "Pacific/Saipan",
      "Pacific/Truk"
    ]
  },
  {
    "value": "Tasmania Standard Time",
    "abbr": "TST",
    "offset": 10,
    "isdst": false,
    "text": "(UTC+10:00) Hobart",
    "utc": [
      "Australia/Currie",
      "Australia/Hobart"
    ]
  },
  {
    "value": "Yakutsk Standard Time",
    "abbr": "YST",
    "offset": 9,
    "isdst": false,
    "text": "(UTC+09:00) Yakutsk",
    "utc": [
      "Asia/Chita",
      "Asia/Khandyga",
      "Asia/Yakutsk"
    ]
  },
  {
    "value": "Central Pacific Standard Time",
    "abbr": "CPST",
    "offset": 11,
    "isdst": false,
    "text": "(UTC+11:00) Solomon Is., New Caledonia",
    "utc": [
      "Antarctica/Macquarie",
      "Etc/GMT-11",
      "Pacific/Efate",
      "Pacific/Guadalcanal",
      "Pacific/Kosrae",
      "Pacific/Noumea",
      "Pacific/Ponape"
    ]
  },
  {
    "value": "Vladivostok Standard Time",
    "abbr": "VST",
    "offset": 11,
    "isdst": false,
    "text": "(UTC+11:00) Vladivostok",
    "utc": [
      "Asia/Sakhalin",
      "Asia/Ust-Nera",
      "Asia/Vladivostok"
    ]
  },
  {
    "value": "New Zealand Standard Time",
    "abbr": "NZST",
    "offset": 12,
    "isdst": false,
    "text": "(UTC+12:00) Auckland, Wellington",
    "utc": [
      "Antarctica/McMurdo",
      "Pacific/Auckland"
    ]
  },
  {
    "value": "UTC+12",
    "abbr": "U",
    "offset": 12,
    "isdst": false,
    "text": "(UTC+12:00) Coordinated Universal Time+12",
    "utc": [
      "Etc/GMT-12",
      "Pacific/Funafuti",
      "Pacific/Kwajalein",
      "Pacific/Majuro",
      "Pacific/Nauru",
      "Pacific/Tarawa",
      "Pacific/Wake",
      "Pacific/Wallis"
    ]
  },
  {
    "value": "Fiji Standard Time",
    "abbr": "FST",
    "offset": 12,
    "isdst": false,
    "text": "(UTC+12:00) Fiji",
    "utc": [
      "Pacific/Fiji"
    ]
  },
  {
    "value": "Magadan Standard Time",
    "abbr": "MST",
    "offset": 12,
    "isdst": false,
    "text": "(UTC+12:00) Magadan",
    "utc": [
      "Asia/Anadyr",
      "Asia/Kamchatka",
      "Asia/Magadan",
      "Asia/Srednekolymsk"
    ]
  },
  {
    "value": "Kamchatka Standard Time",
    "abbr": "KDT",
    "offset": 13,
    "isdst": true,
    "text": "(UTC+12:00) Petropavlovsk-Kamchatsky - Old",
    "utc": [
      "Asia/Kamchatka"
    ]
  },
  {
    "value": "Tonga Standard Time",
    "abbr": "TST",
    "offset": 13,
    "isdst": false,
    "text": "(UTC+13:00) Nuku\'alofa",
    "utc": [
      "Etc/GMT-13",
      "Pacific/Enderbury",
      "Pacific/Fakaofo",
      "Pacific/Tongatapu"
    ]
  },
  {
    "value": "Samoa Standard Time",
    "abbr": "SST",
    "offset": 13,
    "isdst": false,
    "text": "(UTC+13:00) Samoa",
    "utc": [
      "Pacific/Apia"
    ]
  }
]
';
    $timezones = json_decode($timezones);
    $utcs = [];

    foreach ($timezones as $timezone) {
        foreach ($timezone->utc as $u) {
            $utcs[$u] = $timezone->text;

        }
    }
    $errors = [];
    $arr = [
        'St. John\'s' => 'St_Johns',
        'Oranjestad' => 'Bermuda',
        'Canberra' => 'Melbourne',
        'Manama' => 'Dubai',
        'Bridgetown' => 'Bermuda',
        'Belmopan' => 'Chicago',
        'Hamilton' => 'Dubai',
        'Sucre' => 'Dubai',
        'Andorra la Vella' => 'Noronha',
        'Tirana' => 'Noronha',
        'The_Valley' => 'Bermuda',
        'Brasilia' => 'Sao_Paulo',
        'Diego Garcia' => 'Belize',
        'Bandar Seri Begawan' => 'Belize',
        'Beijing' => 'Shanghai',
        'Flying Fish Cove' => 'Creston',
        'Flying Fish Cove' => 'Creston',
    ];
    foreach (\App\Country::all() as $country) {
        try {
            $c = Str::before($country->timezone[0], '/');
            if ($c !== '(') {
                $timezone = $c . '/' . str_replace(' ', '_', $country->capital);
                $country->timezone = $utcs[$timezone];
                $country->save();
            }


        } catch (Exception $e) {
            $errors[] = $country->capital;
        }

    }
    dd($errors);
});


Route::get('/country', function (\Illuminate\Http\Request $request) {
    $pops = '
[{
    "country_name": "Afghanistan",
    "country_code": "93",
    "lang_name": "pashto",
    "country_code_name": "af",
    "lang_code": "ps"
}, {
    "country_name": "Albania",
    "country_code": "355",
    "lang_name": "albanian",
    "country_code_name": "al",
    "lang_code": "sq"
}, {
    "country_name": "Algeria",
    "country_code": "213",
    "lang_name": "tamazight (latin)",
    "country_code_name": "dz",
    "lang_code": "tzm"
},  {
    "country_name": "Argentina",
    "country_code": "54",
    "lang_name": "spanish",
    "country_code_name": "ar",
    "lang_code": "es"
}, {
    "country_name": "Armenia",
    "country_code": "374",
    "lang_name": "armenian",
    "country_code_name": "am",
    "lang_code": "hy"
},  {
    "country_name": "Australia",
    "country_code": "61",
    "lang_name": "english",
    "country_code_name": "au",
    "lang_code": "en"
}, {
    "country_name": "Austria",
    "country_code": "43",
    "lang_name": "german",
    "country_code_name": "at",
    "lang_code": "de"
}, {
    "country_name": "Azerbaijan",
    "country_code": "994",
    "lang_name": "azeri (latin)",
    "country_code_name": "az",
    "lang_code": "az"
},  {
    "country_name": "Bahrain",
    "country_code": "973",
    "lang_name": "arabic",
    "country_code_name": "bh",
    "lang_code": "ar"
}, {
    "country_name": "Bangladesh",
    "country_code": "880",
    "lang_name": "bengali",
    "country_code_name": "bd",
    "lang_code": "bn"
},  {
    "country_name": "Belarus",
    "country_code": "375",
    "lang_name": "belarusian",
    "country_code_name": "by",
    "lang_code": "be"
}, {
    "country_name": "Belgium",
    "country_code": "32",
    "lang_name": "french",
    "country_code_name": "be",
    "lang_code": "fr"
}, {
    "country_name": "Belize",
    "country_code": "501",
    "lang_name": "english",
    "country_code_name": "bz",
    "lang_code": "en"
},  {
    "country_name": "Bolivia",
    "country_code": "591",
    "lang_name": "spanish",
    "country_code_name": "bo",
    "lang_code": "es"
}, {
    "country_name": "Bosnia and Herzegovina",
    "country_code": "387",
    "lang_name": "serbian (latin)",
    "country_code_name": "ba",
    "lang_code": "sr"
},  {
    "country_name": "Brazil",
    "country_code": "55",
    "lang_name": "portuguese",
    "country_code_name": "br",
    "lang_code": "pt"
}, {
    "country_name": "Brunei",
    "country_code": "673",
    "lang_name": "malay",
    "country_code_name": "bn",
    "lang_code": "ms"
}, {
    "country_name": "Bulgaria",
    "country_code": "359",
    "lang_name": "bulgarian",
    "country_code_name": "bg",
    "lang_code": "bg"
},  {
    "country_name": "Cambodia",
    "country_code": "855",
    "lang_name": "khmer",
    "country_code_name": "kh",
    "lang_code": "km"
},  {
    "country_name": "Canada",
    "country_code": "1",
    "lang_name": "mohawk",
    "country_code_name": "ca",
    "lang_code": "moh"
}, {
    "country_name": "Chile",
    "country_code": "56",
    "lang_name": "spanish",
    "country_code_name": "cl",
    "lang_code": "es"
}, {
    "country_name": "China",
    "country_code": "86",
    "lang_name": "yi",
    "country_code_name": "cn",
    "lang_code": "ii"
},{
    "country_name": "Colombia",
    "country_code": "57",
    "lang_name": "spanish",
    "country_code_name": "co",
    "lang_code": "es"
}, {
    "country_name": "Costa Rica",
    "country_code": "506",
    "lang_name": "spanish",
    "country_code_name": "cr",
    "lang_code": "es"
}, {
    "country_name": "Croatia",
    "country_code": "385",
    "lang_name": "croatian",
    "country_code_name": "hr",
    "lang_code": "hr"
}, {
    "country_name": "Czech Republic",
    "country_code": "420",
    "lang_name": "czech",
    "country_code_name": "cz",
    "lang_code": "cs"
}, {
    "country_name": "Denmark",
    "country_code": "45",
    "lang_name": "danish",
    "country_code_name": "dk",
    "lang_code": "da"
}, {
    "country_code": "1767",
    "country_code_name": "dm",
    "country_name": "Dominica"
}, {
    "country_name": "Dominican Republic",
    "country_code": "1849",
    "lang_name": "spanish",
    "country_code_name": "do",
    "lang_code": "es"
}, {
    "country_name": "Dominican Republic",
    "country_code": "1829",
    "lang_name": "spanish",
    "country_code_name": "do",
    "lang_code": "es"
}, {
    "country_name": "Dominican Republic",
    "country_code": "1809",
    "lang_name": "spanish",
    "country_code_name": "do",
    "lang_code": "es"
}, {
    "country_name": "Ecuador",
    "country_code": "593",
    "lang_name": "spanish",
    "country_code_name": "ec",
    "lang_code": "es"
}, {
    "country_name": "Egypt",
    "country_code": "20",
    "lang_name": "arabic",
    "country_code_name": "eg",
    "lang_code": "ar"
}, {
    "country_name": "El Salvador",
    "country_code": "503",
    "lang_name": "spanish",
    "country_code_name": "sv",
    "lang_code": "es"
}, {
    "country_code": "240",
    "country_code_name": "gq",
    "country_name": "Equatorial Guinea"
}, {
    "country_code": "291",
    "country_code_name": "er",
    "country_name": "Eritrea"
}, {
    "country_name": "Estonia",
    "country_code": "372",
    "lang_name": "estonian",
    "country_code_name": "ee",
    "lang_code": "et"
}, {
    "country_name": "Ethiopia",
    "country_code": "251",
    "lang_name": "amharic",
    "country_code_name": "et",
    "lang_code": "am"
}, {
    "country_name": "Faroe Islands",
    "country_code": "298",
    "lang_name": "faroese",
    "country_code_name": "fo",
    "lang_code": "fo"
}, {
    "country_code": "679",
    "country_code_name": "fj",
    "country_name": "Fiji"
}, {
    "country_name": "Finland",
    "country_code": "358",
    "lang_name": "swedish",
    "country_code_name": "fi",
    "lang_code": "sv"
}, {
    "country_name": "France",
    "country_code": "33",
    "lang_name": "occitan",
    "country_code_name": "fr",
    "lang_code": "oc"
}, {
    "country_code": "689",
    "country_code_name": "pf",
    "country_name": "French Polynesia"
}, {
    "country_code": "241",
    "country_code_name": "ga",
    "country_name": "Gabon"
}, {
    "country_code": "220",
    "country_code_name": "gm",
    "country_name": "Gambia"
}, {
    "country_name": "Georgia",
    "country_code": "995",
    "lang_name": "georgian",
    "country_code_name": "ge",
    "lang_code": "ka"
}, {
    "country_name": "Germany",
    "country_code": "49",
    "lang_name": "upper sorbian",
    "country_code_name": "de",
    "lang_code": "hsb"
}, {
    "country_code": "350",
    "country_code_name": "gi",
    "country_name": "Gibraltar"
}, {
    "country_name": "Greece",
    "country_code": "30",
    "lang_name": "greek",
    "country_code_name": "gr",
    "lang_code": "el"
}, {
    "country_name": "Greenland",
    "country_code": "299",
    "lang_name": "greenlandic",
    "country_code_name": "gl",
    "lang_code": "kl"
}, {
    "country_code": "1473",
    "country_code_name": "gd",
    "country_name": "Grenada"
}, {
    "country_code": "590",
    "country_code_name": "gp",
    "country_name": "Guadeloupe"
}, {
    "country_code": "1671",
    "country_code_name": "gu",
    "country_name": "Guam"
}, {
    "country_name": "Guatemala",
    "country_code": "502",
    "lang_name": "spanish",
    "country_code_name": "gt",
    "lang_code": "es"
}, {
    "country_code": "245",
    "country_code_name": "gw",
    "country_name": "Guinea-Bissau"
}, {
    "country_code": "592",
    "country_code_name": "gy",
    "country_name": "Guyana"
}, {
    "country_code": "509",
    "country_code_name": "ht",
    "country_name": "Haiti"
}, {
    "country_name": "Honduras",
    "country_code": "504",
    "lang_name": "spanish",
    "country_code_name": "hn",
    "lang_code": "es"
}, {
    "country_name": "Hong Kong",
    "country_code": "852",
    "lang_name": "chinese (traditional) legacy",
    "country_code_name": "hk",
    "lang_code": "zh"
}, {
    "country_name": "Hungary",
    "country_code": "36",
    "lang_name": "hungarian",
    "country_code_name": "hu",
    "lang_code": "hu"
}, {
    "country_name": "Iceland",
    "country_code": "354",
    "lang_name": "icelandic",
    "country_code_name": "is",
    "lang_code": "is"
}, {
    "country_name": "India",
    "country_code": "91",
    "lang_name": "telugu",
    "country_code_name": "in",
    "lang_code": "te"
}, {
    "country_name": "Indonesia",
    "country_code": "62",
    "lang_name": "indonesian",
    "country_code_name": "id",
    "lang_code": "id"
}, {
    "country_name": "Iran",
    "country_code": "98",
    "lang_name": "persian",
    "country_code_name": "ir",
    "lang_code": "fa"
}, {
    "country_name": "Iraq",
    "country_code": "964",
    "lang_name": "arabic",
    "country_code_name": "iq",
    "lang_code": "ar"
}, {
    "country_name": "Ireland",
    "country_code": "353",
    "lang_name": "irish",
    "country_code_name": "ie",
    "lang_code": "ga"
}, {
    "country_name": "Israel",
    "country_code": "972",
    "lang_name": "hebrew",
    "country_code_name": "il",
    "lang_code": "he"
}, {
    "country_name": "Italy",
    "country_code": "39",
    "lang_name": "italian",
    "country_code_name": "it",
    "lang_code": "it"
}, {
    "country_name": "Jamaica",
    "country_code": "1876",
    "lang_name": "english",
    "country_code_name": "jm",
    "lang_code": "en"
}, {
    "country_name": "Japan",
    "country_code": "81",
    "lang_name": "japanese",
    "country_code_name": "jp",
    "lang_code": "ja"
}, {
    "country_name": "Jordan",
    "country_code": "962",
    "lang_name": "arabic",
    "country_code_name": "jo",
    "lang_code": "ar"
}, {
    "country_name": "Kazakhstan",
    "country_code": "7",
    "lang_name": "kazakh",
    "country_code_name": "kz",
    "lang_code": "kk"
}, {
    "country_name": "Kenya",
    "country_code": "254",
    "lang_name": "kiswahili",
    "country_code_name": "ke",
    "lang_code": "sw"
}, {
    "country_code": "686",
    "country_code_name": "ki",
    "country_name": "Kiribati"
}, {
    "country_name": "Kuwait",
    "country_code": "965",
    "lang_name": "arabic",
    "country_code_name": "kw",
    "lang_code": "ar"
}, {
    "country_name": "Kyrgyzstan",
    "country_code": "996",
    "lang_name": "kyrgyz",
    "country_code_name": "kg",
    "lang_code": "ky"
}, {
    "country_name": "Laos",
    "country_code": "856",
    "lang_name": "lao",
    "country_code_name": "la",
    "lang_code": "lo"
}, {
    "country_name": "Latvia",
    "country_code": "371",
    "lang_name": "latvian",
    "country_code_name": "lv",
    "lang_code": "lv"
}, {
    "country_name": "Lebanon",
    "country_code": "961",
    "lang_name": "arabic",
    "country_code_name": "lb",
    "lang_code": "ar"
}, {
    "country_code": "266",
    "country_code_name": "ls",
    "country_name": "Lesotho"
}, {
    "country_code": "231",
    "country_code_name": "lr",
    "country_name": "Liberia"
}, {
    "country_name": "Libya",
    "country_code": "218",
    "lang_name": "arabic",
    "country_code_name": "ly",
    "lang_code": "ar"
}, {
    "country_name": "Liechtenstein",
    "country_code": "423",
    "lang_name": "german",
    "country_code_name": "li",
    "lang_code": "de"
}, {
    "country_name": "Lithuania",
    "country_code": "370",
    "lang_name": "lithuanian",
    "country_code_name": "lt",
    "lang_code": "lt"
}, {
    "country_name": "Luxembourg",
    "country_code": "352",
    "lang_name": "luxembourgish",
    "country_code_name": "lu",
    "lang_code": "lb"
}, {
    "country_name": "Macau",
    "country_code": "853",
    "lang_name": "chinese (traditional) legacy",
    "country_code_name": "mo",
    "lang_code": "zh"
}, {
    "country_name": "Macedonia",
    "country_code": "389",
    "lang_name": "macedonian (fyrom)",
    "country_code_name": "mk",
    "lang_code": "mk"
}, {
    "country_code": "261",
    "country_code_name": "mg",
    "country_name": "Madagascar"
}, {
    "country_code": "265",
    "country_code_name": "mw",
    "country_name": "Malawi"
}, {
    "country_name": "Malaysia",
    "country_code": "60",
    "lang_name": "malay",
    "country_code_name": "my",
    "lang_code": "ms"
}, {
    "country_name": "Maldives",
    "country_code": "960",
    "lang_name": "divehi",
    "country_code_name": "mv",
    "lang_code": "dv"
}, {
    "country_code": "223",
    "country_code_name": "ml",
    "country_name": "Mali"
}, {
    "country_name": "Malta",
    "country_code": "356",
    "lang_name": "maltese",
    "country_code_name": "mt",
    "lang_code": "mt"
}, {
    "country_code": "692",
    "country_code_name": "mh",
    "country_name": "Marshall Islands"
}, {
    "country_code": "596",
    "country_code_name": "mq",
    "country_name": "Martinique"
}, {
    "country_code": "222",
    "country_code_name": "mr",
    "country_name": "Mauritania"
}, {
    "country_code": "230",
    "country_code_name": "mu",
    "country_name": "Mauritius"
}, {
    "country_code": "262",
    "country_code_name": "yt",
    "country_name": "Mayotte"
}, {
    "country_name": "Mexico",
    "country_code": "52",
    "lang_name": "spanish",
    "country_code_name": "mx",
    "lang_code": "es"
}, {
    "country_code": "373",
    "country_code_name": "md",
    "country_name": "Moldova"
}, {
    "country_name": "Monaco",
    "country_code": "377",
    "lang_name": "french",
    "country_code_name": "mc",
    "lang_code": "fr"
}, {
    "country_name": "Mongolia",
    "country_code": "976",
    "lang_name": "mongolian (cyrillic)",
    "country_code_name": "mn",
    "lang_code": "mn"
}, {
    "country_name": "Montenegro",
    "country_code": "382",
    "lang_name": "serbian (latin)",
    "country_code_name": "me",
    "lang_code": "sr"
}, {
    "country_code": "1664",
    "country_code_name": "ms",
    "country_name": "Montserrat"
}, {
    "country_name": "Morocco",
    "country_code": "212",
    "lang_name": "arabic",
    "country_code_name": "ma",
    "lang_code": "ar"
}, {
    "country_code": "258",
    "country_code_name": "mz",
    "country_name": "Mozambique"
}, {
    "country_code": "264",
    "country_code_name": "na",
    "country_name": "Namibia"
}, {
    "country_code": "674",
    "country_code_name": "nr",
    "country_name": "Nauru"
}, {
    "country_name": "Nepal",
    "country_code": "977",
    "lang_name": "nepali",
    "country_code_name": "np",
    "lang_code": "ne"
}, {
    "country_name": "Netherlands",
    "country_code": "31",
    "lang_name": "frisian",
    "country_code_name": "nl",
    "lang_code": "fy"
}, {
    "country_code": "599",
    "country_code_name": "cw",
    "country_name": "Cura\u00e7ao"
}, {
    "country_code": "687",
    "country_code_name": "nc",
    "country_name": "New Caledonia"
}, {
    "country_name": "New Zealand",
    "country_code": "64",
    "lang_name": "maori",
    "country_code_name": "nz",
    "lang_code": "mi"
}, {
    "country_name": "Nicaragua",
    "country_code": "505",
    "lang_name": "spanish",
    "country_code_name": "ni",
    "lang_code": "es"
}, {
    "country_code": "227",
    "country_code_name": "ne",
    "country_name": "Niger"
}, {
    "country_name": "Nigeria",
    "country_code": "234",
    "lang_name": "yoruba",
    "country_code_name": "ng",
    "lang_code": "yo"
}, {
    "country_code": "683",
    "country_code_name": "nu",
    "country_name": "Niue"
}, {
    "country_code": "672",
    "country_code_name": "nf",
    "country_name": "Norfolk Island"
}, {
    "country_code": "1670",
    "country_code_name": "mp",
    "country_name": "Northern Mariana Islands"
}, {
    "country_code": "850",
    "country_code_name": "kp",
    "country_name": "North Korea"
}, {
    "country_name": "Norway",
    "country_code": "47",
    "lang_name": "sami (southern)",
    "country_code_name": "no",
    "lang_code": "sma"
}, {
    "country_name": "Oman",
    "country_code": "968",
    "lang_name": "arabic",
    "country_code_name": "om",
    "lang_code": "ar"
}, {
    "country_name": "Pakistan",
    "country_code": "92",
    "lang_name": "urdu",
    "country_code_name": "pk",
    "lang_code": "ur"
}, {
    "country_code": "680",
    "country_code_name": "pw",
    "country_name": "Palau"
}, {
    "country_code": "970",
    "country_code_name": "ps",
    "country_name": "Palestine"
}, {
    "country_name": "Panama",
    "country_code": "507",
    "lang_name": "spanish",
    "country_code_name": "pa",
    "lang_code": "es"
}, {
    "country_code": "675",
    "country_code_name": "pg",
    "country_name": "Papua New Guinea"
}, {
    "country_name": "Paraguay",
    "country_code": "595",
    "lang_name": "spanish",
    "country_code_name": "py",
    "lang_code": "es"
}, {
    "country_name": "Peru",
    "country_code": "51",
    "lang_name": "spanish",
    "country_code_name": "pe",
    "lang_code": "es"
}, {
    "country_name": "Philippines",
    "country_code": "63",
    "lang_name": "english",
    "country_code_name": "ph",
    "lang_code": "en"
}, {
    "country_code": "870",
    "country_code_name": "pn",
    "country_name": "Pitcairn Islands"
}, {
    "country_name": "Poland",
    "country_code": "48",
    "lang_name": "polish",
    "country_code_name": "pl",
    "lang_code": "pl"
}, {
    "country_name": "Portugal",
    "country_code": "351",
    "lang_name": "portuguese",
    "country_code_name": "pt",
    "lang_code": "pt"
}, {
    "country_name": "Puerto Rico",
    "country_code": "1787",
    "lang_name": "spanish",
    "country_code_name": "pr",
    "lang_code": "es"
}, {
    "country_name": "Qatar",
    "country_code": "974",
    "lang_name": "arabic",
    "country_code_name": "qa",
    "lang_code": "ar"
}, {
    "country_code": "262",
    "country_code_name": "re",
    "country_name": "R\u00e9union"
}, {
    "country_name": "Romania",
    "country_code": "40",
    "lang_name": "romanian",
    "country_code_name": "ro",
    "lang_code": "ro"
}, {
    "country_name": "Russia",
    "country_code": "7",
    "lang_name": "yakut",
    "country_code_name": "ru",
    "lang_code": "sah"
}, {
    "country_name": "Rwanda",
    "country_code": "250",
    "lang_name": "kinyarwanda",
    "country_code_name": "rw",
    "lang_code": "rw"
}, {
    "country_code": "290",
    "country_code_name": "sh",
    "country_name": "Saint Helena"
}, {
    "country_code": "1869",
    "country_code_name": "kn",
    "country_name": "Saint Kitts and Nevis"
}, {
    "country_code": "1758",
    "country_code_name": "lc",
    "country_name": "Saint Lucia"
}, {
    "country_code": "1599",
    "country_code_name": "mf",
    "country_name": "Saint Martin"
}, {
    "country_code": "508",
    "country_code_name": "pm",
    "country_name": "Saint Pierre and Miquelon"
}, {
    "country_code": "1784",
    "country_code_name": "vc",
    "country_name": "Saint Vincent and the Grenadines"
}, {
    "country_code": "685",
    "country_code_name": "ws",
    "country_name": "Samoa"
}, {
    "country_code": "378",
    "country_code_name": "sm",
    "country_name": "San Marino"
}, {
    "country_code": "239",
    "country_code_name": "st",
    "country_name": "S\u00e3o Tom\u00e9 and Pr\u00edncipe"
}, {
    "country_name": "Saudi Arabia",
    "country_code": "966",
    "lang_name": "arabic",
    "country_code_name": "sa",
    "lang_code": "ar"
}, {
    "country_name": "Senegal",
    "country_code": "221",
    "lang_name": "wolof",
    "country_code_name": "sn",
    "lang_code": "wo"
}, {
    "country_name": "Serbia",
    "country_code": "381",
    "lang_name": "serbian (latin)",
    "country_code_name": "rs",
    "lang_code": "sr"
}, {
    "country_code": "248",
    "country_code_name": "sc",
    "country_name": "Seychelles"
}, {
    "country_code": "500",
    "country_code_name": "fk",
    "country_name": "Falkland Islands"
}, {
    "country_code": "232",
    "country_code_name": "sl",
    "country_name": "Sierra Leone"
}, {
    "country_name": "Singapore",
    "country_code": "65",
    "lang_name": "english",
    "country_code_name": "sg",
    "lang_code": "en"
}, {
    "country_name": "Slovakia",
    "country_code": "421",
    "lang_name": "slovak",
    "country_code_name": "sk",
    "lang_code": "sk"
}, {
    "country_name": "Slovenia",
    "country_code": "386",
    "lang_name": "slovenian",
    "country_code_name": "si",
    "lang_code": "sl"
}, {
    "country_code": "677",
    "country_code_name": "sb",
    "country_name": "Solomon Islands"
}, {
    "country_code": "252",
    "country_code_name": "so",
    "country_name": "Somalia"
}, {
    "country_name": "South Africa",
    "country_code": "27",
    "lang_name": "setswana",
    "country_code_name": "za",
    "lang_code": "tn"
}, {
    "country_name": "South Korea",
    "country_code": "82",
    "lang_name": "korean",
    "country_code_name": "kr",
    "lang_code": "ko"
}, {
    "country_code": "211",
    "country_code_name": "ss",
    "country_name": "South Sudan"
}, {
    "country_name": "Spain",
    "country_code": "34",
    "lang_name": "spanish",
    "country_code_name": "es",
    "lang_code": "es"
}, {
    "country_name": "Sri Lanka",
    "country_code": "94",
    "lang_name": "sinhala",
    "country_code_name": "lk",
    "lang_code": "si"
}, {
    "country_code": "249",
    "country_code_name": "sd",
    "country_name": "Sudan"
}, {
    "country_code": "597",
    "country_code_name": "sr",
    "country_name": "Suriname"
}, {
    "country_code": "268",
    "country_code_name": "sz",
    "country_name": "Swaziland"
}, {
    "country_name": "Sweden",
    "country_code": "46",
    "lang_name": "swedish",
    "country_code_name": "se",
    "lang_code": "sv"
}, {
    "country_name": "Switzerland",
    "country_code": "41",
    "lang_name": "romansh",
    "country_code_name": "ch",
    "lang_code": "rm"
}, {
    "country_name": "Syria",
    "country_code": "963",
    "lang_name": "syriac",
    "country_code_name": "sy",
    "lang_code": "syr"
}, {
    "country_name": "Taiwan",
    "country_code": "886",
    "lang_name": "chinese (traditional) legacy",
    "country_code_name": "tw",
    "lang_code": "zh"
}, {
    "country_name": "Tajikistan",
    "country_code": "992",
    "lang_name": "tajik (cyrillic)",
    "country_code_name": "tj",
    "lang_code": "tg"
}, {
    "country_code": "255",
    "country_code_name": "tz",
    "country_name": "Tanzania"
}, {
    "country_name": "Thailand",
    "country_code": "66",
    "lang_name": "thai",
    "country_code_name": "th",
    "lang_code": "th"
}, {
    "country_code": "228",
    "country_code_name": "tg",
    "country_name": "Togo"
}, {
    "country_code": "690",
    "country_code_name": "tk",
    "country_name": "Tokelau"
}, {
    "country_code": "676",
    "country_code_name": "to",
    "country_name": "Tonga"
}, {
    "country_name": "Trinidad and Tobago",
    "country_code": "1868",
    "lang_name": "english",
    "country_code_name": "tt",
    "lang_code": "en"
}, {
    "country_name": "Tunisia",
    "country_code": "216",
    "lang_name": "arabic",
    "country_code_name": "tn",
    "lang_code": "ar"
}, {
    "country_name": "Turkey",
    "country_code": "90",
    "lang_name": "turkish",
    "country_code_name": "tr",
    "lang_code": "tr"
}, {
    "country_name": "Turkmenistan",
    "country_code": "993",
    "lang_name": "turkmen",
    "country_code_name": "tm",
    "lang_code": "tk"
}, {
    "country_code": "1649",
    "country_code_name": "tc",
    "country_name": "Turks and Caicos Islands"
}, {
    "country_code": "688",
    "country_code_name": "tv",
    "country_name": "Tuvalu"
}, {
    "country_code": "256",
    "country_code_name": "ug",
    "country_name": "Uganda"
}, {
    "country_name": "United Kingdom",
    "country_code": "44",
    "lang_name": "welsh",
    "country_code_name": "gb",
    "lang_code": "cy"
}, {
    "country_name": "Ukraine",
    "country_code": "380",
    "lang_name": "ukrainian",
    "country_code_name": "ua",
    "lang_code": "uk"
}, {
    "country_name": "United Arab Emirates",
    "country_code": "971",
    "lang_name": "arabic",
    "country_code_name": "ae",
    "lang_code": "ar"
}, {
    "country_name": "Uruguay",
    "country_code": "598",
    "lang_name": "spanish",
    "country_code_name": "uy",
    "lang_code": "es"
}, {
    "country_name": "United States",
    "country_code": "1",
    "lang_name": "english",
    "country_code_name": "us",
    "lang_code": "en"
}, {
    "country_name": "Uzbekistan",
    "country_code": "998",
    "lang_name": "uzbek (latin)",
    "country_code_name": "uz",
    "lang_code": "uz"
}, {
    "country_code": "678",
    "country_code_name": "vu",
    "country_name": "Vanuatu"
}, {
    "country_name": "Venezuela",
    "country_code": "58",
    "lang_name": "spanish",
    "country_code_name": "ve",
    "lang_code": "es"
}, {
    "country_name": "Vietnam",
    "country_code": "84",
    "lang_name": "vietnamese",
    "country_code_name": "vn",
    "lang_code": "vi"
}, {
    "country_code": "1340",
    "country_code_name": "vi",
    "country_name": "Virgin Islands"
}, {
    "country_code": "681",
    "country_code_name": "wf",
    "country_name": "Wallis and Futuna"
}, {
    "country_name": "Yemen",
    "country_code": "967",
    "lang_name": "arabic",
    "country_code_name": "ye",
    "lang_code": "ar"
}, {
    "country_code": "260",
    "country_code_name": "zm",
    "country_name": "Zambia"
}, {
    "country_name": "Zimbabwe",
    "country_code": "263",
    "lang_name": "english",
    "country_code_name": "zw",
    "lang_code": "en"
}]';
    $pops = json_decode($pops, TRUE);
    $nuls = [];
    foreach ($pops as $pop) {
        $country = \App\Country::getCode(strtoupper($pop['country_code_name']));
        if ($country === NULL) {
            $nuls[] = $pop['country_code_name'];
        } else {
            if (array_key_exists('lang_name', $pop)) {
                $country->update([
                    'lang' => $pop['lang_name'],
                ]);
            }


        }


    }
    dd($nuls);


});


Auth::routes();
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::get('/home', 'HomeController@index')->name('home');
