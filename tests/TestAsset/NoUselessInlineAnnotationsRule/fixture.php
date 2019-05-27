<?php

namespace SlamPhpStan\Tests\TestAsset\NoUselessInlineAnnotationsRule;

class Foo {
    public function tester()
    {
        /** @var Bar[] $foo1 */
        $foo1 = $this->bar1();

        /** @var Bar $foo2 */
        $foo2 = $this->bar2();

        /** @var Bar $foo2bis */
        $foo2bis = $this->bar2bis();

        /** @var Bar[] $foo3 */
        $foo3 = $this->bar3();

        /** @var Bar $foo4 */
        $foo4 = $this->bar4();

        $no = $this->bar1();
        $no = $this->bar2();
        $no = $this->bar2bis();
        $no = $this->bar3();
        $no = $this->bar4();

        /** @var Bar[] $xyz */
        $foo1 = $this->bar1();

        /** @var Bar $xyz */
        $foo2 = $this->bar2();

        /** @var Bar $xyz */
        $foo2bis = $this->bar2bis();

        /** @var Bar[] $xyz */
        $foo3 = $this->bar3();

        /** @var Bar $xyz */
        $foo4 = $this->bar4();
    }

    /**
     * @return Bar[]
     */
    public function bar1(): array
    {
        return [new Bar()];
    }

    public function bar2(): Bar
    {
        return new Bar();
    }

    /**
     * @return Bar
     */
    public function bar2bis()
    {
        return new Bar();
    }

    public function bar3(): array
    {
        return [new Bar()];
    }

    public function bar4()
    {
        return new Bar();
    }
}

class Bar {}
