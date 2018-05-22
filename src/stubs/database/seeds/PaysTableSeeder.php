<?php

use Illuminate\Database\Seeder;

class PaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('pays')->truncate();

	    \DB::table('pays')->insert([
			[
				'continent_id' => 1,
				'slug' => 'afrique-du-sud',
				'name' => 'Afrique du Sud'
			],
			[
				'continent_id' => 1,
				'slug' => 'algerie',
				'name' => 'Algérie'
			],
			[
				'continent_id' => 1,
				'slug' => 'angola',
				'name' => 'Angola'
			],
			[
				'continent_id' => 1,
				'slug' => 'benin',
				'name' => 'Bénin'
			],
			[
				'continent_id' => 1,
				'slug' => 'botswana',
				'name' => 'Botswana'
			],
			[
				'continent_id' => 1,
				'slug' => 'burkina',
				'name' => 'Burkina '
			],
			[
				'continent_id' => 1,
				'slug' => 'burundi',
				'name' => 'Burundi'
			],
			[
				'continent_id' => 1,
				'slug' => 'cameroun',
				'name' => 'Cameroun'
			],
			[
				'continent_id' => 1,
				'slug' => 'cap-vert',
				'name' => 'Cap-Vert'
			],
			[
				'continent_id' => 1,
				'slug' => 'comores',
				'name' => 'Comores'
			],
			[
				'continent_id' => 1,
				'slug' => 'cote-d-ivoire',
				'name' => 'Côte d\'Ivoire'
			],
			[
				'continent_id' => 1,
				'slug' => 'djibouti',
				'name' => 'Djibouti'
			],
			[
				'continent_id' => 1,
				'slug' => 'egypte',
				'name' => 'Égypte'
			],
			[
				'continent_id' => 1,
				'slug' => 'erythree',
				'name' => 'Érythrée'
			],
			[
				'continent_id' => 1,
				'slug' => 'ethiopie',
				'name' => 'Éthiopie'
			],
			[
				'continent_id' => 1,
				'slug' => 'gabon',
				'name' => 'Gabon'
			],
			[
				'continent_id' => 1,
				'slug' => 'gambie',
				'name' => 'Gambie'
			],
			[
				'continent_id' => 1,
				'slug' => 'ghana',
				'name' => 'Ghana'
			],
			[
				'continent_id' => 1,
				'slug' => 'guinee',
				'name' => 'Guinée'
			],
			[
				'continent_id' => 1,
				'slug' => 'guinee-bissau',
				'name' => 'Guinée-Bissau'
			],
			[
				'continent_id' => 1,
				'slug' => 'guinee-equatoriale',
				'name' => 'Guinée équatoriale'
			],
			[
				'continent_id' => 1,
				'slug' => 'kenya',
				'name' => 'Kenya'
			],
			[
				'continent_id' => 1,
				'slug' => 'lesotho',
				'name' => 'Lesotho'
			],
			[
				'continent_id' => 1,
				'slug' => 'liberia',
				'name' => 'Libéria'
			],
			[
				'continent_id' => 1,
				'slug' => 'libye',
				'name' => 'Libye'
			],
			[
				'continent_id' => 1,
				'slug' => 'madagascar',
				'name' => 'Madagascar'
			],
			[
				'continent_id' => 1,
				'slug' => 'malawi',
				'name' => 'Malawi'
			],
			[
				'continent_id' => 1,
				'slug' => 'mali',
				'name' => 'Mali'
			],
			[
				'continent_id' => 1,
				'slug' => 'maroc',
				'name' => 'Maroc'
			],
			[
				'continent_id' => 1,
				'slug' => 'maurice',
				'name' => 'Maurice'
			],
			[
				'continent_id' => 1,
				'slug' => 'mauritanie',
				'name' => 'Mauritanie'
			],
			[
				'continent_id' => 1,
				'slug' => 'mozambique',
				'name' => 'Mozambique'
			],
			[
				'continent_id' => 1,
				'slug' => 'namibie',
				'name' => 'Namibie'
			],
			[
				'continent_id' => 1,
				'slug' => 'niger',
				'name' => 'Niger'
			],
			[
				'continent_id' => 1,
				'slug' => 'nigeria',
				'name' => 'Nigeria'
			],
			[
				'continent_id' => 1,
				'slug' => 'ouganda',
				'name' => 'Ouganda'
			],
			[
				'continent_id' => 1,
				'slug' => 'republique-centrafricaine',
				'name' => 'République centrafricaine'
			],
			[
				'continent_id' => 1,
				'slug' => 'republique-democratique-du-congo',
				'name' => 'République démocratique du Congo'
			],
			[
				'continent_id' => 1,
				'slug' => 'republique-du-congo',
				'name' => 'République du Congo'
			],
			[
				'continent_id' => 1,
				'slug' => 'rwanda',
				'name' => 'Rwanda'
			],
			[
				'continent_id' => 1,
				'slug' => 'sao-tome-et-principe',
				'name' => 'Sao Tomé-et-Principe'
			],
			[
				'continent_id' => 1,
				'slug' => 'senegal',
				'name' => 'Sénégal'
			],
			[
				'continent_id' => 1,
				'slug' => 'seychelles',
				'name' => 'Seychelles'
			],
			[
				'continent_id' => 1,
				'slug' => 'sierra-leone',
				'name' => 'Sierra Leone'
			],
			[
				'continent_id' => 1,
				'slug' => 'somalie',
				'name' => 'Somalie'
			],
			[
				'continent_id' => 1,
				'slug' => 'soudan',
				'name' => 'Soudan'
			],
			[
				'continent_id' => 1,
				'slug' => 'soudan-du-sud',
				'name' => 'Soudan du Sud'
			],
			[
				'continent_id' => 1,
				'slug' => 'swaziland',
				'name' => 'Swaziland'
			],
			[
				'continent_id' => 1,
				'slug' => 'tanzanie',
				'name' => 'Tanzanie'
			],
			[
				'continent_id' => 1,
				'slug' => 'tchad',
				'name' => 'Tchad'
			],
			[
				'continent_id' => 1,
				'slug' => 'togo',
				'name' => 'Togo'
			],
			[
				'continent_id' => 1,
				'slug' => 'tunisie',
				'name' => 'Tunisie'
			],
			[
				'continent_id' => 1,
				'slug' => 'zambie',
				'name' => 'Zambie'
			],
			[
				'continent_id' => 1,
				'slug' => 'zimbabwe',
				'name' => 'Zimbabwe'
			],
			[
				'continent_id' => 2,
				'slug' => 'antigua-et-barbuda',
				'name' => 'Antigua-et-Barbuda'
			],
			[
				'continent_id' => 2,
				'slug' => 'argentine',
				'name' => 'Argentine'
			],
			[
				'continent_id' => 2,
				'slug' => 'bahamas',
				'name' => 'Bahamas'
			],
			[
				'continent_id' => 2,
				'slug' => 'barbade',
				'name' => 'Barbade'
			],
			[
				'continent_id' => 2,
				'slug' => 'belize',
				'name' => 'Belize'
			],
			[
				'continent_id' => 2,
				'slug' => 'bolivie',
				'name' => 'Bolivie'
			],
			[
				'continent_id' => 2,
				'slug' => 'bresil',
				'name' => 'Brésil'
			],
			[
				'continent_id' => 2,
				'slug' => 'canada',
				'name' => 'Canada'
			],
			[
				'continent_id' => 2,
				'slug' => 'chili',
				'name' => 'Chili'
			],
			[
				'continent_id' => 2,
				'slug' => 'colombie',
				'name' => 'Colombie'
			],
			[
				'continent_id' => 2,
				'slug' => 'costa-rica',
				'name' => 'Costa Rica'
			],
			[
				'continent_id' => 2,
				'slug' => 'cuba',
				'name' => 'Cuba'
			],
			[
				'continent_id' => 2,
				'slug' => 'dominique',
				'name' => 'Dominique'
			],
			[
				'continent_id' => 2,
				'slug' => 'equateur',
				'name' => 'Équateur'
			],
			[
				'continent_id' => 2,
				'slug' => 'etats-unis',
				'name' => 'États-Unis'
			],
			[
				'continent_id' => 2,
				'slug' => 'grenade',
				'name' => 'Grenade'
			],
			[
				'continent_id' => 2,
				'slug' => 'guatemala',
				'name' => 'Guatemala'
			],
			[
				'continent_id' => 2,
				'slug' => 'guyane',
				'name' => 'Guyane'
			],
			[
				'continent_id' => 2,
				'slug' => 'haiti',
				'name' => 'Haïti'
			],
			[
				'continent_id' => 2,
				'slug' => 'honduras',
				'name' => 'Honduras'
			],
			[
				'continent_id' => 2,
				'slug' => 'jamaique',
				'name' => 'Jamaïque'
			],
			[
				'continent_id' => 2,
				'slug' => 'mexique',
				'name' => 'Mexique'
			],
			[
				'continent_id' => 2,
				'slug' => 'nicaragua',
				'name' => 'Nicaragua'
			],
			[
				'continent_id' => 2,
				'slug' => 'panama',
				'name' => 'Panama'
			],
			[
				'continent_id' => 2,
				'slug' => 'paraguay',
				'name' => 'Paraguay'
			],
			[
				'continent_id' => 2,
				'slug' => 'perou',
				'name' => 'Pérou'
			],
			[
				'continent_id' => 2,
				'slug' => 'republique-dominicaine',
				'name' => 'République dominicaine'
			],
			[
				'continent_id' => 2,
				'slug' => 'saint-christophe-et-nieves',
				'name' => 'Saint-Christophe-et-Niévès'
			],
			[
				'continent_id' => 2,
				'slug' => 'saint-vincent-et-les grenadines',
				'name' => 'Saint-Vincent-et-les Grenadines'
			],
			[
				'continent_id' => 2,
				'slug' => 'sainte-lucie',
				'name' => 'Sainte-Lucie'
			],
			[
				'continent_id' => 2,
				'slug' => 'salvador',
				'name' => 'Salvador'
			],
			[
				'continent_id' => 2,
				'slug' => 'suriname',
				'name' => 'Suriname'
			],
			[
				'continent_id' => 2,
				'slug' => 'trinite-et-tobago',
				'name' => 'Trinité-et-Tobago'
			],
			[
				'continent_id' => 2,
				'slug' => 'uruguay',
				'name' => 'Uruguay'
			],
			[
				'continent_id' => 2,
				'slug' => 'venezuela',
				'name' => 'Venezuela'
			],
			[
				'continent_id' => 3,
				'slug' => 'afghanistan',
				'name' => 'Afghanistan'
			],
			[
				'continent_id' => 3,
				'slug' => 'arabie-saoudite',
				'name' => 'Arabie saoudite'
			],
			[
				'continent_id' => 3,
				'slug' => 'armenie',
				'name' => 'Arménie'
			],
			[
				'continent_id' => 3,
				'slug' => 'azerbaidjan',
				'name' => 'Azerbaïdjan'
			],
			[
				'continent_id' => 3,
				'slug' => 'bahrein',
				'name' => 'Bahreïn'
			],
			[
				'continent_id' => 3,
				'slug' => 'bangladesh',
				'name' => 'Bangladesh'
			],
			[
				'continent_id' => 3,
				'slug' => 'bhoutan',
				'name' => 'Bhoutan'
			],
			[
				'continent_id' => 3,
				'slug' => 'birmanie',
				'name' => 'Birmanie'
			],
			[
				'continent_id' => 3,
				'slug' => 'brunei',
				'name' => 'Brunei'
			],
			[
				'continent_id' => 3,
				'slug' => 'cambodge',
				'name' => 'Cambodge'
			],
			[
				'continent_id' => 3,
				'slug' => 'chine',
				'name' => 'Chine'
			],
			[
				'continent_id' => 3,
				'slug' => 'coree-du-nord',
				'name' => 'Corée du Nord'
			],
			[
				'continent_id' => 3,
				'slug' => 'coree-du-sud',
				'name' => 'Corée du Sud'
			],
			[
				'continent_id' => 3,
				'slug' => 'emirats-arabes-unis',
				'name' => 'Émirats arabes unis'
			],
			[
				'continent_id' => 3,
				'slug' => 'georgie',
				'name' => 'Géorgie'
			],
			[
				'continent_id' => 3,
				'slug' => 'inde',
				'name' => 'Inde'
			],
			[
				'continent_id' => 3,
				'slug' => 'indonesie',
				'name' => 'Indonésie'
			],
			[
				'continent_id' => 3,
				'slug' => 'irak',
				'name' => 'Irak'
			],
			[
				'continent_id' => 3,
				'slug' => 'iran',
				'name' => 'Iran'
			],
			[
				'continent_id' => 3,
				'slug' => 'israel',
				'name' => 'Israël'
			],
			[
				'continent_id' => 3,
				'slug' => 'japon',
				'name' => 'Japon'
			],
			[
				'continent_id' => 3,
				'slug' => 'jordanie',
				'name' => 'Jordanie'
			],
			[
				'continent_id' => 3,
				'slug' => 'kazakhstan',
				'name' => 'Kazakhstan'
			],
			[
				'continent_id' => 3,
				'slug' => 'kirghizistan',
				'name' => 'Kirghizistan'
			],
			[
				'continent_id' => 3,
				'slug' => 'koweit',
				'name' => 'Koweït'
			],
			[
				'continent_id' => 3,
				'slug' => 'laos',
				'name' => 'Laos'
			],
			[
				'continent_id' => 3,
				'slug' => 'liban',
				'name' => 'Liban'
			],
			[
				'continent_id' => 3,
				'slug' => 'malaisie',
				'name' => 'Malaisie'
			],
			[
				'continent_id' => 3,
				'slug' => 'maldives',
				'name' => 'Maldives'
			],
			[
				'continent_id' => 3,
				'slug' => 'mongolie',
				'name' => 'Mongolie'
			],
			[
				'continent_id' => 3,
				'slug' => 'nepal',
				'name' => 'Népal'
			],
			[
				'continent_id' => 3,
				'slug' => 'oman',
				'name' => 'Oman'
			],
			[
				'continent_id' => 3,
				'slug' => 'ouzbekistan',
				'name' => 'Ouzbékistan'
			],
			[
				'continent_id' => 3,
				'slug' => 'pakistan',
				'name' => 'Pakistan'
			],
			[
				'continent_id' => 3,
				'slug' => 'palestine',
				'name' => 'Palestine'
			],
			[
				'continent_id' => 3,
				'slug' => 'philippines',
				'name' => 'Philippines'
			],
			[
				'continent_id' => 3,
				'slug' => 'qatar',
				'name' => 'Qatar'
			],
			[
				'continent_id' => 3,
				'slug' => 'singapour',
				'name' => 'Singapour'
			],
			[
				'continent_id' => 3,
				'slug' => 'sri-lanka',
				'name' => 'Sri Lanka'
			],
			[
				'continent_id' => 3,
				'slug' => 'syrie',
				'name' => 'Syrie'
			],
			[
				'continent_id' => 3,
				'slug' => 'tadjikistan',
				'name' => 'Tadjikistan'
			],
			[
				'continent_id' => 3,
				'slug' => 'thailande',
				'name' => 'Thaïlande'
			],
			[
				'continent_id' => 3,
				'slug' => 'timor-oriental',
				'name' => 'Timor oriental'
			],
			[
				'continent_id' => 3,
				'slug' => 'turkmenistan',
				'name' => 'Turkménistan'
			],
			[
				'continent_id' => 3,
				'slug' => 'turquie',
				'name' => 'Turquie'
			],
			[
				'continent_id' => 3,
				'slug' => 'viet-nam',
				'name' => 'Viêt Nam'
			],
			[
				'continent_id' => 3,
				'slug' => 'yemen',
				'name' => 'Yémen'
			],
			[
				'continent_id' => 4,
				'slug' => 'albanie',
				'name' => 'Albanie'
			],
			[
				'continent_id' => 4,
				'slug' => 'allemagne-0-6',
				'name' => 'Allemagne 0 à 6'
			],
			[
				'continent_id' => 4,
				'slug' => 'andorre',
				'name' => 'Andorre'
			],
			[
				'continent_id' => 4,
				'slug' => 'autriche',
				'name' => 'Autriche'
			],
			[
				'continent_id' => 4,
				'slug' => 'belgique',
				'name' => 'Belgique'
			],
			[
				'continent_id' => 4,
				'slug' => 'bielorussie',
				'name' => 'Biélorussie'
			],
			[
				'continent_id' => 4,
				'slug' => 'bosnie-herzegovine',
				'name' => 'Bosnie-Herzégovine'
			],
			[
				'continent_id' => 4,
				'slug' => 'bulgarie',
				'name' => 'Bulgarie'
			],
			[
				'continent_id' => 4,
				'slug' => 'chypre',
				'name' => 'Chypre'
			],
			[
				'continent_id' => 4,
				'slug' => 'croatie',
				'name' => 'Croatie'
			],
			[
				'continent_id' => 4,
				'slug' => 'danemark',
				'name' => 'Danemark'
			],
			[
				'continent_id' => 4,
				'slug' => 'espagne',
				'name' => 'Espagne'
			],
			[
				'continent_id' => 4,
				'slug' => 'estonie',
				'name' => 'Estonie'
			],
			[
				'continent_id' => 4,
				'slug' => 'finlande',
				'name' => 'Finlande'
			],
			[
				'continent_id' => 4,
				'slug' => 'france',
				'name' => 'France'
			],
			[
				'continent_id' => 4,
				'slug' => 'grece',
				'name' => 'Grèce'
			],
			[
				'continent_id' => 4,
				'slug' => 'hongrie',
				'name' => 'Hongrie'
			],
			[
				'continent_id' => 4,
				'slug' => 'irlande',
				'name' => 'Irlande'
			],
			[
				'continent_id' => 4,
				'slug' => 'islande',
				'name' => 'Islande'
			],
			[
				'continent_id' => 4,
				'slug' => 'italie',
				'name' => 'Italie'
			],
			[
				'continent_id' => 4,
				'slug' => 'lettonie',
				'name' => 'Lettonie'
			],
			[
				'continent_id' => 4,
				'slug' => 'liechtenstein',
				'name' => 'Liechtenstein'
			],
			[
				'continent_id' => 4,
				'slug' => 'lituanie',
				'name' => 'Lituanie'
			],
			[
				'continent_id' => 4,
				'slug' => 'luxembourg',
				'name' => 'Luxembourg'
			],
			[
				'continent_id' => 4,
				'slug' => 'malte',
				'name' => 'Malte'
			],
			[
				'continent_id' => 4,
				'slug' => 'moldavie',
				'name' => 'Moldavie'
			],
			[
				'continent_id' => 4,
				'slug' => 'monaco',
				'name' => 'Monaco'
			],
			[
				'continent_id' => 4,
				'slug' => 'montenegro',
				'name' => 'Monténégro'
			],
			[
				'continent_id' => 4,
				'slug' => 'norvege',
				'name' => 'Norvège'
			],
			[
				'continent_id' => 4,
				'slug' => 'pays-bas',
				'name' => 'Pays-Bas'
			],
			[
				'continent_id' => 4,
				'slug' => 'pologne',
				'name' => 'Pologne'
			],
			[
				'continent_id' => 4,
				'slug' => 'portugal',
				'name' => 'Portugal'
			],
			[
				'continent_id' => 4,
				'slug' => 'republique-de-macedoine',
				'name' => 'République de Macédoine'
			],
			[
				'continent_id' => 4,
				'slug' => 'republique-tcheque',
				'name' => 'République tchèque'
			],
			[
				'continent_id' => 4,
				'slug' => 'roumanie',
				'name' => 'Roumanie'
			],
			[
				'continent_id' => 4,
				'slug' => 'royaume-uni',
				'name' => 'Royaume-Uni'
			],
			[
				'continent_id' => 4,
				'slug' => 'russie',
				'name' => 'Russie'
			],
			[
				'continent_id' => 4,
				'slug' => 'saint-marin',
				'name' => 'Saint-Marin'
			],
			[
				'continent_id' => 4,
				'slug' => 'serbie',
				'name' => 'Serbie'
			],
			[
				'continent_id' => 4,
				'slug' => 'slovaquie',
				'name' => 'Slovaquie'
			],
			[
				'continent_id' => 4,
				'slug' => 'slovénie',
				'name' => 'Slovénie'
			],
			[
				'continent_id' => 4,
				'slug' => 'suede',
				'name' => 'Suède'
			],
			[
				'continent_id' => 4,
				'slug' => 'suisse',
				'name' => 'Suisse'
			],
			[
				'continent_id' => 4,
				'slug' => 'ukraine',
				'name' => 'Ukraine'
			],
			[
				'continent_id' => 4,
				'slug' => 'vatican',
				'name' => 'Vatican'
			],
			[
				'continent_id' => 5,
				'slug' => 'australie',
				'name' => 'Australie'
			],
			[
				'continent_id' => 5,
				'slug' => 'fidji',
				'name' => 'Fidji'
			],
			[
				'continent_id' => 5,
				'slug' => 'kiribati',
				'name' => 'Kiribati'
			],
			[
				'continent_id' => 5,
				'slug' => 'marshall',
				'name' => 'Marshall'
			],
			[
				'continent_id' => 5,
				'slug' => 'micronesie',
				'name' => 'Micronésie'
			],
			[
				'continent_id' => 5,
				'slug' => 'nauru',
				'name' => 'Nauru'
			],
			[
				'continent_id' => 5,
				'slug' => 'nouvelle-zelande',
				'name' => 'Nouvelle-Zélande'
			],
			[
				'continent_id' => 5,
				'slug' => 'palaos',
				'name' => 'Palaos'
			],
			[
				'continent_id' => 5,
				'slug' => 'papouasie-nouvelle-guinee',
				'name' => 'Papouasie-Nouvelle-Guinée'
			],
			[
				'continent_id' => 5,
				'slug' => 'salomon',
				'name' => 'Salomon'
			],
			[
				'continent_id' => 5,
				'slug' => 'samoa',
				'name' => 'Samoa'
			],
			[
				'continent_id' => 5,
				'slug' => 'tonga',
				'name' => 'Tonga'
			],
			[
				'continent_id' => 5,
				'slug' => 'tuvalu',
				'name' => 'Tuvalu'
			],
			[
				'continent_id' => 5,
				'slug' => 'vanuatu',
				'name' => 'Vanuatu'
			],
			[
				'continent_id' => 4,
				'slug' => 'allemagne-7-9',
				'name' => 'Allemagne 7 à 9'
			],
			[
				'continent_id' => 1,
				'slug' => 'la-reunion',
				'name' => 'La Réunion'
			]
		]);
    }
}
