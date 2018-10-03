# Installation
## Bundle
## JS
Insérez la librairie Google avec la balise </head> :
    
    <script src='https://www.google.com/recaptcha/api.js'></script>
    
##Config

```
wh_recaptcha:
    public_key: ''
    private_key: ''
```


    
# Mise en place sur un formulaire
## FormType
Ajouter un champ dans le formulaire, ex :

    ->add(
        'recaptcha',
        RecaptchaType::class
    )

## Thème
Appliquer le thème au formulaire :

    {% form_theme form with ['my_base.html.twig', 'WHRecaptchaBundle:Form:fields.html.twig'] %}