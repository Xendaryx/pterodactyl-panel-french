<?php

return [
    'accepted' => 'Le champ :attribute doit être accepté.',
    'active_url' => 'Le champ :attribute n’est pas une URL valide.',
    'after' => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal' => 'Le champ :attribute doit être une date postérieure ou égale au :date.',
    'alpha' => 'Le champ :attribute ne peut contenir que des lettres.',
    'alpha_dash' => 'Le champ :attribute ne peut contenir que des lettres, des chiffres et des tirets.',
    'alpha_num' => 'Le champ :attribute ne peut contenir que des lettres et des chiffres.',
    'array' => 'Le champ :attribute doit être un tableau.',
    'before' => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date antérieure ou égale au :date.',

    'between' => [
        'numeric' => 'La valeur de :attribute doit être comprise entre :min et :max.',
        'file' => 'La taille du fichier :attribute doit être comprise entre :min et :max kilo-octets.',
        'string' => 'Le champ :attribute doit contenir entre :min et :max caractères.',
        'array' => 'Le champ :attribute doit contenir entre :min et :max éléments.',
    ],

    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'date' => 'Le champ :attribute n’est pas une date valide.',
    'date_format' => 'Le champ :attribute ne correspond pas au format :format.',
    'different' => 'Les champs :attribute et :other doivent être différents.',
    'digits' => 'Le champ :attribute doit contenir :digits chiffres.',
    'digits_between' => 'Le champ :attribute doit contenir entre :min et :max chiffres.',
    'dimensions' => 'Les dimensions de l’image :attribute ne sont pas valides.',
    'distinct' => 'Le champ :attribute contient une valeur en double.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'exists' => 'La valeur sélectionnée pour :attribute est invalide.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute est obligatoire.',
    'image' => 'Le champ :attribute doit être une image.',
    'in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'in_array' => 'Le champ :attribute n’existe pas dans :other.',
    'integer' => 'Le champ :attribute doit être un nombre entier.',
    'ip' => 'Le champ :attribute doit être une adresse IP valide.',
    'json' => 'Le champ :attribute doit être une chaîne JSON valide.',

    'max' => [
        'numeric' => 'La valeur de :attribute ne peut pas être supérieure à :max.',
        'file' => 'La taille du fichier :attribute ne peut pas dépasser :max kilo-octets.',
        'string' => 'Le champ :attribute ne peut pas contenir plus de :max caractères.',
        'array' => 'Le champ :attribute ne peut pas contenir plus de :max éléments.',
    ],

    'mimes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'mimetypes' => 'Le champ :attribute doit être un fichier de type : :values.',

    'min' => [
        'numeric' => 'La valeur de :attribute doit être au moins égale à :min.',
        'file' => 'La taille du fichier :attribute doit être d’au moins :min kilo-octets.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
        'array' => 'Le champ :attribute doit contenir au moins :min éléments.',
    ],

    'not_in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'present' => 'Le champ :attribute doit être présent.',
    'regex' => 'Le format du champ :attribute est invalide.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_if' => 'Le champ :attribute est obligatoire lorsque :other vaut :value.',
    'required_unless' => 'Le champ :attribute est obligatoire sauf si :other contient :values.',
    'required_with' => 'Le champ :attribute est obligatoire lorsque :values est présent.',
    'required_with_all' => 'Le champ :attribute est obligatoire lorsque :values est présent.',
    'required_without' => 'Le champ :attribute est obligatoire lorsque :values n’est pas présent.',
    'required_without_all' => 'Le champ :attribute est obligatoire lorsqu’aucune des valeurs :values n’est présente.',
    'same' => 'Les champs :attribute et :other doivent correspondre.',

    'size' => [
        'numeric' => 'La valeur de :attribute doit être égale à :size.',
        'file' => 'La taille du fichier :attribute doit être de :size kilo-octets.',
        'string' => 'Le champ :attribute doit contenir :size caractères.',
        'array' => 'Le champ :attribute doit contenir :size éléments.',
    ],

    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone' => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique' => 'La valeur du champ :attribute est déjà utilisée.',
    'uploaded' => 'Le téléchargement du fichier :attribute a échoué.',
    'url' => 'Le format du champ :attribute est invalide.',

    'attributes' => [
        'name' => 'nom',
        'username' => 'nom d’utilisateur',
        'name_first' => 'prénom',
        'name_last' => 'nom',
        'owner_id' => 'propriétaire',
        'allocation_id' => 'allocation principale',
        'source' => 'source',
        'target' => 'cible',
        'short' => 'code court',
        'import_file' => 'fichier d’importation',
        'fqdn' => 'FQDN',
        'memory' => 'mémoire totale',
        'memory_overallocate' => 'surallocation de mémoire',
        'disk' => 'espace disque total',
        'disk_overallocate' => 'surallocation du disque',
    ],

    // Logique de validation interne de Pterodactyl.
    'internal' => [
        'variable_value' => 'variable :env',
        'invalid_password' => 'Le mot de passe fourni est incorrect pour ce compte.',
    ],
];
