<?php

// translations for Callcocam/Acl
return [

     'do-you-want-to-create-permissions' => "Você deseja criar permissões?",
     'do-you-want-to-create-roles' => "Você deseja criar funções?",
     'forms' => [
          'user' => [
               'type' => [
                    'label' => 'Tipo de usuário',
                    'options' => [
                         'user' => 'Usuário',
                         'client' => 'Cliente',
                    ],
                    'columnSpan' => [
                         'md' => 2,
                    ],
                    'required' => true,
               ],
               'name' => [
                    'label' => 'Nome completo',
                    'placeholder' => 'Informe seu nome completo',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'email' => [
                    'label' => 'Email',
                    'placeholder' => 'Informe seu email',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'office' => [
                    'label' => 'Cargo',
                    'placeholder' => 'Informe seu cargo',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'password' => [
                    'label' => 'Senha',
                    'placeholder' => 'Informe sua senha',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'password_confirmation' => [
                    'label' => 'Confirmação de senha',
                    'placeholder' => 'Informe sua confirmação de senha',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'status' => [
                    'label' => 'Status',
                    'placeholder' => 'Informe seu status',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'date_birth' => [
                    'label' => 'Data de nascimento',
                    'placeholder' => 'Informe sua data de nascimento',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'genre' => [
                    'label' => 'Gênero',
                    'placeholder' => 'Informe seu gênero',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'email_verified' => [
                    'label' => 'Email verificado',
                    'helpText' => '',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'data' => [
                    'access' => [
                         'label' => 'Configurações de acesso',
                         'helpText' => '',
                         // 'columnSpan'  
                         // 'required'
                         // 'hidden'
                         // 'hiddenLabel'
                         // 'maxLength' 
                    ]
               ],
               'roles' => [
                    'label' => 'Funções',
                    'helpText' => '',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength'  
               ],



          ],
          'address' => [
               'modelLabel' => 'Endereço',
               'pluralModelLabel' => 'Endereços',
               'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Informe o nome',
               ],
               'zip' => [
                    'label' => 'CEP',
                    'placeholder' => 'Informe o CEP',
               ],                  
               'street' => [
                    'label' => 'Rua',
                    'placeholder' => 'Informe a rua',
               ],
               'number' => [
                    'label' => 'Número',
                    'placeholder' => 'Informe o número',
               ],
               'complement' => [
                    'label' => 'Complemento',
                    'placeholder' => 'Informe o complemento',
               ],
               'district' => [
                    'label' => 'Bairro',
                    'placeholder' => 'Informe o bairro',
               ],
               'city' => [
                    'label' => 'Cidade',
                    'placeholder' => 'Informe a cidade',
               ],
               'state' => [
                    'label' => 'Estado',
                    'placeholder' => 'Informe o estado',
               ],
               'country' => [
                    'label' => 'País',
                    'placeholder' => 'Informe o país',
               ],
               'longitude' => [
                    'label' => 'Longitude',
                    'placeholder' => 'Informe a longitude',
               ],
               'latitude' => [
                    'label' => 'Latitude',
                    'placeholder' => 'Informe a latitude',
               ],

          ],
          'contact' => [
               'modelLabel' => 'Contato',
               'pluralModelLabel' => 'Contatos',
               'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Informe o nome',
               ],
               'description' => [
                    'label' => 'Descrição',
                    'placeholder' => 'Informe a descrição',
               ],
          ],
          'document' => [
               'modelLabel' => 'Documento',
               'pluralModelLabel' => 'Documentos',
               'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Informe o nome',
               ],
               'description' => [
                    'label' => 'Descrição',
                    'placeholder' => 'Informe a descrição',
               ],
          ],
          'social' => [
               'modelLabel' => 'Social',
               'pluralModelLabel' => 'Socials',
               'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Informe o nome',
               ],
               'description' => [
                    'label' => 'Descrição',
                    'placeholder' => 'Informe a descrição',
               ],
          ],
          'permission'=>[
               'access_group_id' => [
                    'label' => 'Grupos de acesso',
                    'placeholder' => 'Informe os grupos de acesso',
                    'helpText' => '',
                    // 'columnSpan'  
                    // 'required'
                    // 'hidden'
                    // 'hiddenLabel'
                    // 'maxLength' 
               ],
               'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Informe o nome',
               ],
               'slug' => [
                    'label' => 'Slug',
                    'placeholder' => 'Informe o slug',
               ],
               'description' => [
                    'label' => 'Descrição',
                    'placeholder' => 'Informe a descrição',
               ],
               'status' => [
                    'label' => 'Status',
                    'placeholder' => 'Informe o status',
               ], 
          ],
          'role'=>[
               'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Informe o nome',
               ],
               'slug' => [
                    'label' => 'Slug',
                    'placeholder' => 'Informe o slug',
               ],
               'description' => [
                    'label' => 'Descrição',
                    'placeholder' => 'Informe a descrição',
               ],
               'status' => [
                    'label' => 'Status',
                    'placeholder' => 'Informe o status',
               ],
               'special' => [
                    'label' => 'Permissões especiais',
                    'placeholder' => 'Informe as permissões especiais',
               ],
               'fieldset' => [
                    'label' => 'Permissões',
                    'placeholder' => 'Informe as permissões',
               ],

          ]
     ],
     'permission' => [
          'groups' => [
               'access_groups' => [
                    'name' => 'Grupos de acesso',
               ],
          ],
     ],
     'columns' => [
          'permission' => [
               'access_groups'=>'Grupos de acesso',
               'name' => 'Nome',
               'slug' => 'Slug',
               'description' => 'Descrição',
               'status' => 'Status',
               'created_at' => 'Criado em',
               'updated_at' => 'Atualizado em',
               'deleted_at' => 'Deletado em',
          ],
     ]
];
