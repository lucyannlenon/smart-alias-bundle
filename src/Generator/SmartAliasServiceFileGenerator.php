<?php
namespace LENON\SmartAliasBundle\Generator;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use LENON\SmartAliasBundle\Attribute\DefaultImplementationFor;
use LENON\SmartAliasBundle\Attribute\ImplementationFor;
use RuntimeException;

class SmartAliasServiceFileGenerator
{
    public function __construct(private string $projectDir) {}

    public function generate(): void
    {
        $finder = (new Finder())->in($this->projectDir.'/src')->name('*.php');
        $aliases = [];
        $tags = [];

        foreach ($finder as $file) {
            $className = $this->extractClassName($file->getRealPath());
            if (!$className || !class_exists($className)) continue;

            $ref = new ReflectionClass($className);

            foreach ($ref->getAttributes(DefaultImplementationFor::class) as $attr) {
                $args = $attr->newInstance();

                if (isset($aliases[$args->interface])) {
                    throw new RuntimeException(sprintf(
                        "Duplicate DefaultImplementationFor for interface '%s' found in classes '%s' and '%s'.",
                        $args->interface,
                        $aliases[$args->interface],
                        $className
                    ));
                }

                $aliases[$args->interface] = $className;
            }

            foreach ($ref->getAttributes(ImplementationFor::class) as $attr) {
                $args = $attr->newInstance();
                $tags[$className][] = $args->tag ?? $args->interface;
            }
        }

        $this->dumpFile($aliases, $tags);
    }

    private function dumpFile(array $aliases, array $tags): void
    {
        $lines = [];
        $lines[] = "<?php";
        $lines[] = "use Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ContainerConfigurator;";
        $lines[] = "return function (ContainerConfigurator \$configurator) {";
        $lines[] = "    \$services = \$configurator->services();";

        foreach ($aliases as $interface => $impl) {
            $lines[] = "    \$services->alias(\\$interface::class, \\$impl::class)->public();";
        }

        foreach ($tags as $class => $tagsList) {
            foreach ($tagsList as $tag) {
                $lines[] = "    \$services->set(\\$class::class)->tag('$tag');";
            }
        }

        $lines[] = "};";

        $path = $this->projectDir.'/config/smart_alias/services.php';
        @mkdir(dirname($path), 0777, true);
        file_put_contents($path, implode("\n", $lines));
    }

    private function extractClassName(string $file): ?string
    {
        $contents = file_get_contents($file);
        if (!preg_match('/namespace (.*);/', $contents, $ns)) return null;
        if (!preg_match('/class ([^\s]+)/', $contents, $class)) return null;
        return $ns[1].'\\'.$class[1];
    }
}