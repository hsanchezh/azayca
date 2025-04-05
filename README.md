Esta es una aplicación web para el TFG "Aplicación para la gestión de traslados de pacientes de la ONG AZAYCA" en UNIR.

Se trata de una aplicación escrita en PHP con el framework Symfony. Como SGBD se utiliza postgresql. El entorno de desarrollo es una máquina con Debian 13 (Trixie) y el IDE PHPStorm.

El proyecto base se ha creado a través de composer:
  composer create-project symfony/skeleton:"7.2.x" azayca

Se han insalado también los siguientes complementos:
  composer require webapp
  composer require twig
  composer require symfony/flex
  composer require doctrine/doctrine-bundle
  composer require symfony/orm-pack
  composer require --dev symfony/maker-bundle
  composer require knplabs/knp-menu-bundle
  composer require symfony/form
  composer require symfony/security-bundle
  composer require symfony/http-foundation

La parte visual utiliza Bootstrap. Tanto para la parte de estilos como para la de javascript están incluidas a través de un repositorio cdn en la propia vista.
