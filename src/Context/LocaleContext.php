<?php

declare(strict_types=1);

namespace Setono\SyliusMailchimpPlugin\Context;

use Sylius\Component\Locale\Context\LocaleContextInterface as BaseLocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class LocaleContext implements LocaleContextInterface
{
    /** @var RepositoryInterface */
    private $localeRepository;

    /** @var BaseLocaleContextInterface */
    private $baseLocaleContext;

    public function __construct(RepositoryInterface $localeRepository, BaseLocaleContextInterface $baseLocaleContext)
    {
        $this->localeRepository = $localeRepository;
        $this->baseLocaleContext = $baseLocaleContext;
    }

    public function getLocale(): LocaleInterface
    {
        $code = $this->baseLocaleContext->getLocaleCode();

        /** @var LocaleInterface|null $locale */
        $locale = $this->localeRepository->findOneBy(['code' => $code]);

        if (null === $locale) {
            throw new \RuntimeException(sprintf('No locale found with the code %s', $code));
        }

        return $locale;
    }
}
