<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class FormatterTest extends TestCase
{
    public function testFromKeyValue(): void {
        $data = [ 'foo' => 'bar' ];
        $formatter = FormatObjectList\Factory::fromKeyValue( $data );
        $expected = [
            [
                'value' => 'foo',
                'label' => 'bar',
            ]
        ];
        $this->assertEqualsCanonicalizing($formatter->format(), $expected);
    }

    public function testFromValueKey(): void {
        $data = [ 'foo' => 'bar' ];
        $formatter = FormatObjectList\Factory::fromValueKey( $data );
        $expected = [
            [
                'value' => 'bar',
                'label' => 'foo',
            ]
        ];
        $this->assertEqualsCanonicalizing($formatter->format(), $expected);
    }
}
