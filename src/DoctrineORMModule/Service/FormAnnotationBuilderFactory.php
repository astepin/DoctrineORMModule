<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace DoctrineORMModule\Service;

use DoctrineModule\Service\AbstractFactory;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Interop\Container\ContainerInterface;
use Zend\Form\Factory;

/**
 * Service factory responsible for instantiating {@see \DoctrineORMModule\Form\Annotation\AnnotationBuilder}
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Marco Pivetta <ocramius@gmail.com>
 */
class FormAnnotationBuilderFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return \DoctrineORMModule\Form\Annotation\AnnotationBuilder
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $container->get('doctrine.entitymanager.' . $this->getName());

        $annotationBuilder = new AnnotationBuilder($entityManager);
        
        $annotationBuilder->setFormFactory($this->getFormFactory($container));

        return $annotationBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptionsClass()
    {
    }

    /**
     * Retrieve the form factory
     *
     * @param  ContainerInterface $container
     * @return Factory
     */
    private function getFormFactory(ContainerInterface $container)
    {
        $elements = null;
        
        if ($container->has('FormElementManager')) {
            $elements = $container->get('FormElementManager');
        }

        return new Factory($elements);
    }
}
