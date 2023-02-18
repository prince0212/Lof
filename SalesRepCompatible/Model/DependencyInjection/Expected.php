<?php
namespace Lof\SalesRepCompatible\Model\DependencyInjection;

/**
 * Class Expected
 * @package Lof\SalesRepCompatible\Model\DependencyInjection
 */
class Expected {
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManagerInterface;

    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $argument;

    /**
     * Expected constructor.
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManagerInterface
     * @param string $name
     * @param array $arguments
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManagerInterface,
        $name = '',
        $arguments = []
    )
    {
        $this->objectManagerInterface = $objectManagerInterface;
        $this->name                   = $name;
        $this->argument               = $arguments;
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool|mixed
     */
    public function __call( $name, $arguments )
    {
        $result = false;
        if ( $this->name && class_exists( $this->name ) ) {
            $object = $this->objectManagerInterface->create( $this->name );

            $result = call_user_func_array( [ $object, $name ], $arguments );
        }

        return $result;
    }
}
