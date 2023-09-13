<?php
/**
 * This class has been auto-generated by PHP-DI.
 */
class CompiledContainer extends DI\CompiledContainer{
    const METHOD_MAPPING = array (
  'App\\Service\\ArticleService' => 'get1',
  'subEntry1' => 'get2',
  'App\\Service\\GetUserService' => 'get3',
  'subEntry2' => 'get4',
  'Doctrine\\ORM\\EntityManager' => 'get5',
  'subEntry3' => 'get6',
  'subEntry4' => 'get7',
  'Doctrine\\ORM\\Configuration' => 'get9',
);

    protected function get2()
    {
        return $this->delegateContainer->get('Doctrine\\ORM\\EntityManager');
    }

    protected function get1()
    {
        $object = new App\Service\ArticleService($this->get2());
        return $object;
    }

    protected function get4()
    {
        return $this->delegateContainer->get('Doctrine\\ORM\\EntityManager');
    }

    protected function get3()
    {
        $object = new App\Service\GetUserService($this->get4());
        return $object;
    }

    protected function get6()
    {
        return $this->delegateContainer->get('Doctrine\\DBAL\\Connection');
    }

    protected function get7()
    {
        return $this->delegateContainer->get('Doctrine\\ORM\\Configuration');
    }

    protected function get5()
    {
        $object = new Doctrine\ORM\EntityManager($this->get6(), $this->get7(), NULL);
        return $object;
    }

    protected function get9()
    {
        $object = new Doctrine\ORM\Configuration();
        return $object;
    }

}