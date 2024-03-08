<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatMarcasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('cat_marcas')->delete();

        \DB::table('cat_marcas')->insert(array (
            0 =>
            array (
                'marca' => 'AE',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 1,
            ),
            1 =>
            array (
                'marca' => 'AGR',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 2,
            ),
            2 =>
            array (
                'marca' => 'ALI',
                'nombre' => 'ALIEXPRESS',
                'deleted_at' => NULL,
                'id' => 3,
            ),
            3 =>
            array (
                'marca' => 'AMERICAN',
                'nombre' => 'TUNIX',
                'deleted_at' => NULL,
                'id' => 4,
            ),
            4 =>
            array (
                'marca' => 'ARMA',
                'nombre' => 'CUBRE POLVOS Y SOPORTES',
                'deleted_at' => NULL,
                'id' => 5,
            ),
            5 =>
            array (
                'marca' => 'ASER',
                'nombre' => 'ASER',
                'deleted_at' => NULL,
                'id' => 6,
            ),
            6 =>
            array (
                'marca' => 'ATV',
                'nombre' => 'ROTULAS Y DIRECCION',
                'deleted_at' => NULL,
                'id' => 7,
            ),
            7 =>
            array (
                'marca' => 'AUTOPAR',
                'nombre' => 'AUTOPAR',
                'deleted_at' => NULL,
                'id' => 8,
            ),
            8 =>
            array (
                'marca' => 'B4',
                'nombre' => 'FILTROS B4',
                'deleted_at' => NULL,
                'id' => 9,
            ),
            9 =>
            array (
                'marca' => 'BARDAHL',
                'nombre' => 'ACEITES Y LUBRICANTES',
                'deleted_at' => NULL,
                'id' => 10,
            ),
            10 =>
            array (
                'marca' => 'BOCAR',
                'nombre' => 'B0CAR',
                'deleted_at' => NULL,
                'id' => 11,
            ),
            11 =>
            array (
                'marca' => 'BOGE',
                'nombre' => 'AMORTIGUADORES',
                'deleted_at' => NULL,
                'id' => 12,
            ),
            12 =>
            array (
                'marca' => 'BORGW',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 13,
            ),
            13 =>
            array (
                'marca' => 'BOSCH',
                'nombre' => 'BOSCH',
                'deleted_at' => NULL,
                'id' => 14,
            ),
            14 =>
            array (
                'marca' => 'BREMBO',
                'nombre' => 'BREMBO',
                'deleted_at' => NULL,
                'id' => 15,
            ),
            15 =>
            array (
                'marca' => 'BRITT',
                'nombre' => 'ROTULAS',
                'deleted_at' => NULL,
                'id' => 16,
            ),
            16 =>
            array (
                'marca' => 'BRUCK',
                'nombre' => 'BRUCK',
                'deleted_at' => NULL,
                'id' => 17,
            ),
            17 =>
            array (
                'marca' => 'CAM CHAIN',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 18,
            ),
            18 =>
            array (
                'marca' => 'CARPRO',
                'nombre' => 'ANILLOS DE MOTOR',
                'deleted_at' => NULL,
                'id' => 19,
            ),
            19 =>
            array (
                'marca' => 'CARTER',
                'nombre' => 'CARTER',
                'deleted_at' => NULL,
                'id' => 20,
            ),
            20 =>
            array (
                'marca' => 'CASTROL',
                'nombre' => 'LUBRICANTES CASTROL',
                'deleted_at' => NULL,
                'id' => 21,
            ),
            21 =>
            array (
                'marca' => 'CHAMPION',
                'nombre' => 'BUJIAS',
                'deleted_at' => NULL,
                'id' => 22,
            ),
            22 =>
            array (
                'marca' => 'CHASE',
                'nombre' => 'REFACCIONES SUSPENCION',
                'deleted_at' => NULL,
                'id' => 23,
            ),
            23 =>
            array (
                'marca' => 'CHI',
                'nombre' => 'CHI',
                'deleted_at' => NULL,
                'id' => 24,
            ),
            24 =>
            array (
                'marca' => 'CHROMITE',
                'nombre' => 'TRANSMICION',
                'deleted_at' => NULL,
                'id' => 25,
            ),
            25 =>
            array (
                'marca' => 'CIB',
                'nombre' => 'REFACCIONES EN GENERAL',
                'deleted_at' => NULL,
                'id' => 26,
            ),
            26 =>
            array (
                'marca' => 'CKING',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 27,
            ),
            27 =>
            array (
                'marca' => 'CKT',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 28,
            ),
            28 =>
            array (
                'marca' => 'CLEMEX',
                'nombre' => 'REFACCIONES DE MOTOR',
                'deleted_at' => NULL,
                'id' => 29,
            ),
            29 =>
            array (
                'marca' => 'CLEVITE',
                'nombre' => 'CLEVITE MAHLE',
                'deleted_at' => NULL,
                'id' => 30,
            ),
            30 =>
            array (
                'marca' => 'CODAN',
                'nombre' => 'CODAN MANGUERAS',
                'deleted_at' => NULL,
                'id' => 31,
            ),
            31 =>
            array (
                'marca' => 'CRUMEX',
                'nombre' => 'ROTULAS',
                'deleted_at' => NULL,
                'id' => 32,
            ),
            32 =>
            array (
                'marca' => 'CTI',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 33,
            ),
            33 =>
            array (
                'marca' => 'DAI',
                'nombre' => 'SOPORTES Y CUBREPOLVOS',
                'deleted_at' => NULL,
                'id' => 34,
            ),
            34 =>
            array (
                'marca' => 'DAJ',
                'nombre' => 'JUNTAS Y SUSPENCION',
                'deleted_at' => NULL,
                'id' => 35,
            ),
            35 =>
            array (
                'marca' => 'DAOS',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 36,
            ),
            36 =>
            array (
                'marca' => 'DAOSA',
                'nombre' => 'VARIOS',
                'deleted_at' => NULL,
                'id' => 37,
            ),
            37 =>
            array (
                'marca' => 'DC',
                'nombre' => 'JUNTAS',
                'deleted_at' => NULL,
                'id' => 38,
            ),
            38 =>
            array (
                'marca' => 'DEPO',
                'nombre' => 'ELECTRICO',
                'deleted_at' => NULL,
                'id' => 39,
            ),
            39 =>
            array (
                'marca' => 'DEUSIC',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 40,
            ),
            40 =>
            array (
                'marca' => 'DEVCON',
                'nombre' => 'PEGAMENTO DEVCON',
                'deleted_at' => NULL,
                'id' => 41,
            ),
            41 =>
            array (
                'marca' => 'DIAMOND',
                'nombre' => 'REFACCIONES EN GENERAL',
                'deleted_at' => NULL,
                'id' => 42,
            ),
            42 =>
            array (
                'marca' => 'DING',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 43,
            ),
            43 =>
            array (
                'marca' => 'DOBLE 77',
                'nombre' => 'SUSPECION Y DIRECCION',
                'deleted_at' => NULL,
                'id' => 44,
            ),
            44 =>
            array (
                'marca' => 'DOKURO',
                'nombre' => 'REFACCIONES MOTOR',
                'deleted_at' => NULL,
                'id' => 45,
            ),
            45 =>
            array (
                'marca' => 'DYNAGER',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 46,
            ),
            46 =>
            array (
                'marca' => 'ECOM',
                'nombre' => 'QUIMICOS ECOM',
                'deleted_at' => NULL,
                'id' => 47,
            ),
            47 =>
            array (
                'marca' => 'EDELMANN',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 48,
            ),
            48 =>
            array (
                'marca' => 'EK CHAIN',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 49,
            ),
            49 =>
            array (
                'marca' => 'ENGINE VALVE',
                'nombre' => 'REFACCIONES MOTOR',
                'deleted_at' => NULL,
                'id' => 50,
            ),
            50 =>
            array (
                'marca' => 'EURO-ESPAÑA',
                'nombre' => 'EURO-ESPAÑA SURU SPAÑA',
                'deleted_at' => NULL,
                'id' => 51,
            ),
            51 =>
            array (
                'marca' => 'EUROP',
                'nombre' => 'VARIOS',
                'deleted_at' => NULL,
                'id' => 52,
            ),
            52 =>
            array (
                'marca' => 'EUROPLAST',
                'nombre' => 'MISELANEOS Y ACCESORIOS',
                'deleted_at' => NULL,
                'id' => 53,
            ),
            53 =>
            array (
                'marca' => 'EUROPOWERS',
                'nombre' => 'EUROPOWERS VARIOS',
                'deleted_at' => NULL,
                'id' => 54,
            ),
            54 =>
            array (
                'marca' => 'EUROVAL',
                'nombre' => 'REFACCIONES MOTOR',
                'deleted_at' => NULL,
                'id' => 55,
            ),
            55 =>
            array (
                'marca' => 'FACRO',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 56,
            ),
            56 =>
            array (
                'marca' => 'FEDERAL',
                'nombre' => 'SUSPENCION Y MOTOR',
                'deleted_at' => NULL,
                'id' => 57,
            ),
            57 =>
            array (
                'marca' => 'FEDERAL MOGUL',
                'nombre' => 'FEDERAL MOGUL',
                'deleted_at' => NULL,
                'id' => 58,
            ),
            58 =>
            array (
                'marca' => 'FEELER',
                'nombre' => 'FEELER GAUGE',
                'deleted_at' => NULL,
                'id' => 59,
            ),
            59 =>
            array (
                'marca' => 'FELMAR',
                'nombre' => 'VARIOS',
                'deleted_at' => NULL,
                'id' => 60,
            ),
            60 =>
            array (
                'marca' => 'FINO',
                'nombre' => 'SUSPENSION Y DIRECCION',
                'deleted_at' => NULL,
                'id' => 61,
            ),
            61 =>
            array (
                'marca' => 'FINO AUTO',
                'nombre' => 'SUSPENCION ',
                'deleted_at' => NULL,
                'id' => 62,
            ),
            62 =>
            array (
                'marca' => 'FRA',
                'nombre' => 'FRA',
                'deleted_at' => NULL,
                'id' => 63,
            ),
            63 =>
            array (
                'marca' => 'FRITEC',
                'nombre' => 'FRITEC',
                'deleted_at' => NULL,
                'id' => 64,
            ),
            64 =>
            array (
                'marca' => 'GABRIEL',
                'nombre' => 'GABRIEL AMORTIGUADORES',
                'deleted_at' => NULL,
                'id' => 65,
            ),
            65 =>
            array (
                'marca' => 'GATES',
                'nombre' => 'BANDAS',
                'deleted_at' => NULL,
                'id' => 66,
            ),
            66 =>
            array (
                'marca' => 'GC',
                'nombre' => 'FILTROS GC',
                'deleted_at' => NULL,
                'id' => 67,
            ),
            67 =>
            array (
                'marca' => 'GENERAL ELECTRI',
                'nombre' => 'GENERA ELECTRI FOCOS',
                'deleted_at' => NULL,
                'id' => 68,
            ),
            68 =>
            array (
                'marca' => 'GONHER',
                'nombre' => 'GONHER',
                'deleted_at' => NULL,
                'id' => 69,
            ),
            69 =>
            array (
                'marca' => 'GOODYEAR',
                'nombre' => 'GOODYEAR',
                'deleted_at' => NULL,
                'id' => 70,
            ),
            70 =>
            array (
                'marca' => 'GORILA',
                'nombre' => 'CANDADOS GORILA',
                'deleted_at' => NULL,
                'id' => 71,
            ),
            71 =>
            array (
                'marca' => 'GOTZE',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 72,
            ),
            72 =>
            array (
                'marca' => 'GRANT',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 73,
            ),
            73 =>
            array (
                'marca' => 'GROB',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 74,
            ),
            74 =>
            array (
                'marca' => 'HASTINGS',
                'nombre' => 'ANILLOS DE MOTOR',
                'deleted_at' => NULL,
                'id' => 75,
            ),
            75 =>
            array (
                'marca' => 'HELLA',
                'nombre' => 'HELLA',
                'deleted_at' => NULL,
                'id' => 76,
            ),
            76 =>
            array (
                'marca' => 'HERTA',
                'nombre' => 'REFACIONES',
                'deleted_at' => NULL,
                'id' => 77,
            ),
            77 =>
            array (
                'marca' => 'HOLBERT',
                'nombre' => 'REFACCIONES SUSPENCION DIRECCION',
                'deleted_at' => NULL,
                'id' => 78,
            ),
            78 =>
            array (
                'marca' => 'IFUEL',
                'nombre' => 'IFUEL',
                'deleted_at' => NULL,
                'id' => 79,
            ),
            79 =>
            array (
                'marca' => 'ILLINOIS',
                'nombre' => 'ILLINOIS JUNTAS',
                'deleted_at' => NULL,
                'id' => 80,
            ),
            80 =>
            array (
                'marca' => 'INTERFIL',
                'nombre' => 'FILTROS DE GASOLINA Y AIRE',
                'deleted_at' => NULL,
                'id' => 81,
            ),
            81 =>
            array (
                'marca' => 'IZUMI',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 82,
            ),
            82 =>
            array (
                'marca' => 'JAP',
                'nombre' => 'JAP',
                'deleted_at' => NULL,
                'id' => 83,
            ),
            83 =>
            array (
                'marca' => 'JAP 555',
                'nombre' => 'SUSPENCION Y DIRECCION',
                'deleted_at' => NULL,
                'id' => 84,
            ),
            84 =>
            array (
                'marca' => 'JCMC',
                'nombre' => 'REFACCIONES MOTOR',
                'deleted_at' => NULL,
                'id' => 85,
            ),
            85 =>
            array (
                'marca' => 'JOBSA',
                'nombre' => 'JOBSA',
                'deleted_at' => NULL,
                'id' => 86,
            ),
            86 =>
            array (
                'marca' => 'JPNART',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 87,
            ),
            87 =>
            array (
                'marca' => 'KAPARS',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 88,
            ),
            88 =>
            array (
                'marca' => 'KASHIO',
                'nombre' => 'REFACCIONES SUSPENCION',
                'deleted_at' => NULL,
                'id' => 89,
            ),
            89 =>
            array (
                'marca' => 'KCM',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 90,
            ),
            90 =>
            array (
                'marca' => 'KISHIO',
                'nombre' => 'KISHIO',
                'deleted_at' => NULL,
                'id' => 91,
            ),
            91 =>
            array (
                'marca' => 'KOR',
                'nombre' => 'KOR',
                'deleted_at' => NULL,
                'id' => 92,
            ),
            92 =>
            array (
                'marca' => 'KRAZY',
                'nombre' => 'PEGAMENTO KRAZY',
                'deleted_at' => NULL,
                'id' => 93,
            ),
            93 =>
            array (
                'marca' => 'KUHN',
                'nombre' => 'KUHN',
                'deleted_at' => NULL,
                'id' => 94,
            ),
            94 =>
            array (
                'marca' => 'KYB',
                'nombre' => 'KYB',
                'deleted_at' => NULL,
                'id' => 95,
            ),
            95 =>
            array (
                'marca' => 'LANCER',
                'nombre' => 'LANCER',
                'deleted_at' => NULL,
                'id' => 96,
            ),
            96 =>
            array (
                'marca' => 'LEAL',
                'nombre' => 'REFACCIONES SUSPENSION',
                'deleted_at' => NULL,
                'id' => 97,
            ),
            97 =>
            array (
                'marca' => 'LSFESPORT',
                'nombre' => 'QUIMICOS LSFESPORT',
                'deleted_at' => NULL,
                'id' => 98,
            ),
            98 =>
            array (
                'marca' => 'LTH',
                'nombre' => 'BATERIAS',
                'deleted_at' => NULL,
                'id' => 99,
            ),
            99 =>
            array (
                'marca' => 'LUBRI CLEM',
                'nombre' => 'GRASA LUBRI CLEM',
                'deleted_at' => NULL,
                'id' => 100,
            ),
            100 =>
            array (
                'marca' => 'LUCAS',
                'nombre' => 'ADITIVOS LUCAS',
                'deleted_at' => NULL,
                'id' => 101,
            ),
            101 =>
            array (
                'marca' => 'LUCID',
                'nombre' => 'LUCID ELECTRICO FAROS Y CUARTOS',
                'deleted_at' => NULL,
                'id' => 102,
            ),
            102 =>
            array (
                'marca' => 'LUK',
                'nombre' => 'EMBRAGUE O CLUTCH',
                'deleted_at' => NULL,
                'id' => 103,
            ),
            103 =>
            array (
                'marca' => 'LUSAC',
                'nombre' => 'LUSAC',
                'deleted_at' => NULL,
                'id' => 104,
            ),
            104 =>
            array (
                'marca' => 'MAHLE',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 105,
            ),
            105 =>
            array (
                'marca' => 'MCC',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 106,
            ),
            106 =>
            array (
                'marca' => 'MERC LUB',
                'nombre' => 'ACEITE MERC LUB',
                'deleted_at' => NULL,
                'id' => 107,
            ),
            107 =>
            array (
                'marca' => 'MIZUMO',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 108,
            ),
            108 =>
            array (
                'marca' => 'MOBIL',
                'nombre' => 'LUBRICANTES MOBIL',
                'deleted_at' => NULL,
                'id' => 109,
            ),
            109 =>
            array (
                'marca' => 'MONROE',
                'nombre' => 'MONROE',
                'deleted_at' => NULL,
                'id' => 110,
            ),
            110 =>
            array (
                'marca' => 'MOOG',
                'nombre' => 'REFACCION',
                'deleted_at' => NULL,
                'id' => 111,
            ),
            111 =>
            array (
                'marca' => 'MOPAR',
                'nombre' => 'MOPAR',
                'deleted_at' => NULL,
                'id' => 112,
            ),
            112 =>
            array (
                'marca' => 'MORESA',
                'nombre' => 'PISTONES Y VALVULAS',
                'deleted_at' => NULL,
                'id' => 113,
            ),
            113 =>
            array (
                'marca' => 'MOTOMANS',
                'nombre' => 'DISTRIBUCION Y MOTOR',
                'deleted_at' => NULL,
                'id' => 114,
            ),
            114 =>
            array (
                'marca' => 'MOTORCRAFT',
                'nombre' => 'LUBRICANTES Y AUTOPARTES MOTORCRAFT',
                'deleted_at' => NULL,
                'id' => 115,
            ),
            115 =>
            array (
                'marca' => 'MX 555',
                'nombre' => 'SUSPENCION Y DIRECCION',
                'deleted_at' => NULL,
                'id' => 116,
            ),
            116 =>
            array (
                'marca' => 'NAC',
                'nombre' => 'NAC',
                'deleted_at' => NULL,
                'id' => 117,
            ),
            117 =>
            array (
                'marca' => 'NAPCO',
                'nombre' => 'NAPCO',
                'deleted_at' => NULL,
                'id' => 118,
            ),
            118 =>
            array (
                'marca' => 'NGK',
                'nombre' => 'NGK BUJIAS',
                'deleted_at' => NULL,
                'id' => 119,
            ),
            119 =>
            array (
                'marca' => 'NIKKO',
                'nombre' => 'REFACCIONES EN GENERAL',
                'deleted_at' => NULL,
                'id' => 120,
            ),
            120 =>
            array (
                'marca' => 'NIOHIOKA',
                'nombre' => 'ROTULAS',
                'deleted_at' => NULL,
                'id' => 121,
            ),
            121 =>
            array (
                'marca' => 'NISSAN',
                'nombre' => 'REFACCIONES EN GENERAL ORIGINAL',
                'deleted_at' => NULL,
                'id' => 122,
            ),
            122 =>
            array (
                'marca' => 'NPPN',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 123,
            ),
            123 =>
            array (
                'marca' => 'NPR',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 124,
            ),
            124 =>
            array (
                'marca' => 'OBSOLETO',
                'nombre' => 'MERCACIA DE POCO MOVIMIENTO',
                'deleted_at' => NULL,
                'id' => 125,
            ),
            125 =>
            array (
                'marca' => 'OE',
                'nombre' => 'OE',
                'deleted_at' => NULL,
                'id' => 126,
            ),
            126 =>
            array (
                'marca' => 'ONET',
                'nombre' => 'FRENOS Y MISELANEOS',
                'deleted_at' => NULL,
                'id' => 127,
            ),
            127 =>
            array (
                'marca' => 'OPTIMO',
                'nombre' => 'GENERAL',
                'deleted_at' => NULL,
                'id' => 128,
            ),
            128 =>
            array (
                'marca' => 'OSK',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 129,
            ),
            129 =>
            array (
                'marca' => 'PARAUT',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 130,
            ),
            130 =>
            array (
                'marca' => 'PEAK',
                'nombre' => 'QUIMICOS',
                'deleted_at' => NULL,
                'id' => 131,
            ),
            131 =>
            array (
                'marca' => 'PERFECT CIRCLI ',
                'nombre' => 'ANILLOS',
                'deleted_at' => NULL,
                'id' => 132,
            ),
            132 =>
            array (
                'marca' => 'PERMATEX',
                'nombre' => 'QUIMICOS PERMATEX',
                'deleted_at' => NULL,
                'id' => 133,
            ),
            133 =>
            array (
                'marca' => 'POLISUR',
                'nombre' => 'BUJES Y GOMAS DIVERSOS',
                'deleted_at' => NULL,
                'id' => 134,
            ),
            134 =>
            array (
                'marca' => 'PONTIC',
                'nombre' => 'PONTIC',
                'deleted_at' => NULL,
                'id' => 135,
            ),
            135 =>
            array (
                'marca' => 'POWER LUB',
                'nombre' => 'ACEITE POWER LUB',
                'deleted_at' => NULL,
                'id' => 136,
            ),
            136 =>
            array (
                'marca' => 'PROMO',
                'nombre' => 'PARTES ORIGINALES USADAS',
                'deleted_at' => NULL,
                'id' => 137,
            ),
            137 =>
            array (
                'marca' => 'Q PARTX',
                'nombre' => 'Q PARTX',
                'deleted_at' => NULL,
                'id' => 138,
            ),
            138 =>
            array (
                'marca' => 'QUAKER STATE',
                'nombre' => 'QUIMICOS Y LIBRICANTES QUAKER',
                'deleted_at' => NULL,
                'id' => 139,
            ),
            139 =>
            array (
                'marca' => 'QUEBEC',
                'nombre' => 'JUNTAS DE MOTOR',
                'deleted_at' => NULL,
                'id' => 140,
            ),
            140 =>
            array (
                'marca' => 'RACK END',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 141,
            ),
            141 =>
            array (
                'marca' => 'RAYA',
                'nombre' => 'RAYA',
                'deleted_at' => NULL,
                'id' => 142,
            ),
            142 =>
            array (
                'marca' => 'RESTORE',
                'nombre' => 'QUIMICOS RESTORE',
                'deleted_at' => NULL,
                'id' => 143,
            ),
            143 =>
            array (
                'marca' => 'RN',
                'nombre' => 'RN',
                'deleted_at' => NULL,
                'id' => 144,
            ),
            144 =>
            array (
                'marca' => 'ROMMSA',
                'nombre' => 'SOPORTES',
                'deleted_at' => NULL,
                'id' => 145,
            ),
            145 =>
            array (
                'marca' => 'ROSHFRANS',
                'nombre' => 'ACEITES Y LUBRICANTES',
                'deleted_at' => NULL,
                'id' => 146,
            ),
            146 =>
            array (
                'marca' => 'RS',
                'nombre' => 'SUSPENSION Y FRENOS',
                'deleted_at' => NULL,
                'id' => 147,
            ),
            147 =>
            array (
                'marca' => 'RS AUTOPARTES',
                'nombre' => 'REFACCIONES FRENOS SUSPENSION',
                'deleted_at' => NULL,
                'id' => 148,
            ),
            148 =>
            array (
                'marca' => 'S/M',
                'nombre' => 'SIN MARCA',
                'deleted_at' => NULL,
                'id' => 149,
            ),
            149 =>
            array (
                'marca' => 'SAFETY',
                'nombre' => 'ROTULAS',
                'deleted_at' => NULL,
                'id' => 150,
            ),
            150 =>
            array (
                'marca' => 'SEALED POWER',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 151,
            ),
            151 =>
            array (
                'marca' => 'SELLO V',
                'nombre' => 'SELLO V JUNTAS MOTOR',
                'deleted_at' => NULL,
                'id' => 152,
            ),
            152 =>
            array (
                'marca' => 'SELLOV',
                'nombre' => 'UNTAS MOTOR',
                'deleted_at' => NULL,
                'id' => 153,
            ),
            153 =>
            array (
                'marca' => 'SILVOLITE',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 154,
            ),
            154 =>
            array (
                'marca' => 'SIM',
                'nombre' => 'REFACCIONES SUSPENCION',
                'deleted_at' => NULL,
                'id' => 155,
            ),
            155 =>
            array (
                'marca' => 'SIR',
                'nombre' => 'REFACCIONES SUSPENSION',
                'deleted_at' => NULL,
                'id' => 156,
            ),
            156 =>
            array (
                'marca' => 'SKF',
                'nombre' => 'AUTOPARTES Y QUIMICOS SKF',
                'deleted_at' => NULL,
                'id' => 157,
            ),
            157 =>
            array (
                'marca' => 'SPAICER',
                'nombre' => 'SPAICER TREN DE POTENCIA',
                'deleted_at' => NULL,
                'id' => 158,
            ),
            158 =>
            array (
                'marca' => 'STAR',
                'nombre' => 'SOPORTES Y CUBREPOLVOS',
                'deleted_at' => NULL,
                'id' => 159,
            ),
            159 =>
            array (
                'marca' => 'STEEL',
                'nombre' => 'SUSPENCION Y DIRECCION',
                'deleted_at' => NULL,
                'id' => 160,
            ),
            160 =>
            array (
                'marca' => 'STEEL POWER',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 161,
            ),
            161 =>
            array (
                'marca' => 'STERING',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 162,
            ),
            162 =>
            array (
                'marca' => 'SUPER FORCE',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 163,
            ),
            163 =>
            array (
                'marca' => 'SYD',
                'nombre' => 'DIRECCION Y SUSPENCION',
                'deleted_at' => NULL,
                'id' => 164,
            ),
            164 =>
            array (
                'marca' => 'SYS',
                'nombre' => 'Marca general',
                'deleted_at' => NULL,
                'id' => 165,
            ),
            165 =>
            array (
                'marca' => 'TAIHO',
                'nombre' => 'REFACCIONES MOTOR',
                'deleted_at' => NULL,
                'id' => 166,
            ),
            166 =>
            array (
                'marca' => 'TASBO',
                'nombre' => 'TASBO',
                'deleted_at' => NULL,
                'id' => 167,
            ),
            167 =>
            array (
                'marca' => 'TEBO',
                'nombre' => 'ROTULAS Y DIRECCION',
                'deleted_at' => NULL,
                'id' => 168,
            ),
            168 =>
            array (
                'marca' => 'TECNOFUEL',
                'nombre' => 'BOMBAS DE COMBUSTIBLE',
                'deleted_at' => NULL,
                'id' => 169,
            ),
            169 =>
            array (
                'marca' => 'TEPEYAC',
                'nombre' => 'TEPEYAC MANGUERAS',
                'deleted_at' => NULL,
                'id' => 170,
            ),
            170 =>
            array (
                'marca' => 'TEXAS',
                'nombre' => 'ACEITE TEXAS',
                'deleted_at' => NULL,
                'id' => 171,
            ),
            171 =>
            array (
                'marca' => 'TF',
                'nombre' => 'QUIMICOS TF',
                'deleted_at' => NULL,
                'id' => 172,
            ),
            172 =>
            array (
                'marca' => 'TF VICTOR',
                'nombre' => 'TF VICTOR JUNTAS DE MOTOR',
                'deleted_at' => NULL,
                'id' => 173,
            ),
            173 =>
            array (
                'marca' => 'TIMKEN',
                'nombre' => 'RODAMIENTOS TIMKEN',
                'deleted_at' => NULL,
                'id' => 174,
            ),
            174 =>
            array (
                'marca' => 'TNK',
                'nombre' => 'REFACCION',
                'deleted_at' => NULL,
                'id' => 175,
            ),
            175 =>
            array (
                'marca' => 'TOMCO',
                'nombre' => 'TOMCO',
                'deleted_at' => NULL,
                'id' => 176,
            ),
            176 =>
            array (
                'marca' => 'TRANSTEC',
                'nombre' => 'REPUESTOS DE CAJA DE DIR',
                'deleted_at' => NULL,
                'id' => 177,
            ),
            177 =>
            array (
                'marca' => 'TREE',
                'nombre' => 'AROMATIZANTE',
                'deleted_at' => NULL,
                'id' => 178,
            ),
            178 =>
            array (
                'marca' => 'TREMEC',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 179,
            ),
            179 =>
            array (
                'marca' => 'TROMEX',
                'nombre' => 'TROMEX',
                'deleted_at' => NULL,
                'id' => 180,
            ),
            180 =>
            array (
                'marca' => 'TRUPER',
                'nombre' => 'HERRAMIENTAS TRUPER',
                'deleted_at' => NULL,
                'id' => 181,
            ),
            181 =>
            array (
                'marca' => 'TS',
                'nombre' => 'TS FEDERAL MOGUL',
                'deleted_at' => NULL,
                'id' => 182,
            ),
            182 =>
            array (
                'marca' => 'TUNIX',
                'nombre' => 'TUNIX ACCESORIOS',
                'deleted_at' => NULL,
                'id' => 183,
            ),
            183 =>
            array (
                'marca' => 'TW',
                'nombre' => 'TW',
                'deleted_at' => NULL,
                'id' => 184,
            ),
            184 =>
            array (
                'marca' => 'TW 555',
                'nombre' => 'SUSPENCION Y DIRECCION',
                'deleted_at' => NULL,
                'id' => 185,
            ),
            185 =>
            array (
                'marca' => 'TYC',
                'nombre' => 'ELECTRICO',
                'deleted_at' => NULL,
                'id' => 186,
            ),
            186 =>
            array (
                'marca' => 'UNICAR',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 187,
            ),
            187 =>
            array (
                'marca' => 'UNIFLOW',
                'nombre' => 'UNIFLOW',
                'deleted_at' => NULL,
                'id' => 188,
            ),
            188 =>
            array (
                'marca' => 'UNIPOINT',
                'nombre' => 'UNIPOINT',
                'deleted_at' => NULL,
                'id' => 189,
            ),
            189 =>
            array (
                'marca' => 'URREA',
                'nombre' => 'HERRAMIENTAS URREA',
                'deleted_at' => NULL,
                'id' => 190,
            ),
            190 =>
            array (
                'marca' => 'USA',
                'nombre' => 'USA',
                'deleted_at' => NULL,
                'id' => 191,
            ),
            191 =>
            array (
                'marca' => 'VALEO',
                'nombre' => 'VALEO',
                'deleted_at' => NULL,
                'id' => 192,
            ),
            192 =>
            array (
                'marca' => 'VALMEX',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 193,
            ),
            193 =>
            array (
                'marca' => 'VEHYCO',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 194,
            ),
            194 =>
            array (
                'marca' => 'VULCANO',
                'nombre' => 'JUNTAS',
                'deleted_at' => NULL,
                'id' => 195,
            ),
            195 =>
            array (
                'marca' => 'WAGNER',
                'nombre' => 'AUTOPARTES WAGNER',
                'deleted_at' => NULL,
                'id' => 196,
            ),
            196 =>
            array (
                'marca' => 'WD-40',
                'nombre' => 'QUIMICOS WD-40',
                'deleted_at' => NULL,
                'id' => 197,
            ),
            197 =>
            array (
                'marca' => 'WS',
                'nombre' => 'REFACCIONES MOTOR',
                'deleted_at' => NULL,
                'id' => 198,
            ),
            198 =>
            array (
                'marca' => 'WTB',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 199,
            ),
            199 =>
            array (
                'marca' => 'WURTH',
                'nombre' => 'QUIMICOS',
                'deleted_at' => NULL,
                'id' => 200,
            ),
            200 =>
            array (
                'marca' => 'WYNNS',
                'nombre' => 'WYNNS',
                'deleted_at' => NULL,
                'id' => 201,
            ),
            201 =>
            array (
                'marca' => 'ZUIKO',
                'nombre' => 'REFACCIONES',
                'deleted_at' => NULL,
                'id' => 202,
            ),
        ));


    }
}
