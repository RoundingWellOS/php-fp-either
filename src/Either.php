<?php

namespace PhpFp\Either;

use PhpFp\Either\Constructor\Left;
use PhpFp\Either\Constructor\Right;
/**
 * An OO-looking implementation of Either in PHP.
 */
abstract class Either
{
    /**
     * Construct a new Left instance with a value.
     * @param mixed $x The value to be wrapped.
     * @return A new Left-constructed type.
     */
    public static final function left($x)
    {
        return new Left($x);
    }
    /**
     * Construct a new Right instance with a value.
     * @param mixed $x The value to be wrapped.
     * @return A new Right-constructed type.
     */
    public static final function right($x)
    {
        return new Right($x);
    }
    /**
     * Applicative constructor for Either.
     * @param mixed $x The value to be wrapped.
     * @return A new Right-constructed type.
     */
    public static final function of($x)
    {
        return self::right($x);
    }
    /**
     * Capture an exception-throwing function in an Either.
     * @param callable $f The exception-throwing function.
     * @return Either Right (with success), or Left (with exception).
     */
    public static final function tryCatch(callable $f)
    {
        try {
            return self::of($f());
        } catch (\Exception $e) {
            return self::left($e);
        }
    }
    /**
     * Apply a wrapped parameter to this wrapped function.
     * @param Either $that The wrapped parameter.
     * @return Either The wrapped result.
     */
    public abstract function ap(Either $that);
    /**
     * Map over both sides of the Either.
     * @param callable $f The Left transformer.
     * @param callable $g The Right transformer.
     * @return Either Both sides transformed.
     */
    public abstract function bimap(callable $f, callable $g);
    /**
     * PHP implementation of Haskell Either's bind (>>=).
     * @param callable $f a -> Either e b
     * @return Either Either e b
     */
    public abstract function chain(callable $f);
    /**
     * Standard functor mapping, derived from chain.
     * @param callable $f The transformer for the inner value.
     * @return Either The wrapped, transformed value.
     */
    public abstract function map(callable $f);
    /**
     * Read the value within the monad, left or right.
     * @param callable $f Transformation for Left.
     * @param callable $g Transformation for Right.
     * @return mixed The same type for each branch.
     */
    public abstract function either(callable $f, callable $g);
    /**
     * The inner value of the instance.
     * @var mixed
     */
    protected $value = null;
    /**
     * Standard constructor for an Either instance.
     * @param mixed $value The value to wrap.
     */
    private final function __construct($value)
    {
        $this->value = $value;
    }
}