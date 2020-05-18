<?php

declare(strict_types=1);


namespace App\Command\Executor;


use App\Factory\CountryFactory;
use App\Service\Country\CountryInfoService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadCountryInfoExecutor
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CountryFactory
     */
    private $countryFactory;

    /**
     * @var CountryInfoService
     */
    private $countryInfoService;

    /**
     * DownloadCountryInfoExecutor constructor.
     *
     * @param CountryInfoService $countryInfoService
     * @param EntityManagerInterface $entityManager
     * @param CountryFactory $countryFactory
     */
    public function __construct(CountryInfoService $countryInfoService, EntityManagerInterface $entityManager, CountryFactory $countryFactory)
    {
        $this->entityManager = $entityManager;
        $this->countryFactory = $countryFactory;
        $this->countryInfoService = $countryInfoService;
    }


    /**
     * @param OutputInterface $output
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function execute(OutputInterface $output)
    {
        if ($this->isTableEmpty()) {
            $output->writeln('Start processing country data');
            $countryData = $this->countryInfoService->getCountryData();
            if ($countryData) {
                foreach ($countryData as $countryArray) {
                    $country = $this->countryFactory->createCountryFromArray($countryArray);
                    if (null !== $country) {
                        $this->entityManager->persist($country);
                    }
                }

                $this->entityManager->flush();
            }

            $output->writeln('Finish processing country data for: '.count($countryData));
        } else {
            $output->writeln('Countries data is exist');
        }
    }

    /**
     * @return bool
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    private function isTableEmpty(): bool
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('count(c.id)');
        $qb->from('App:Country', 'c');

        return 0 === $qb->getQuery()->getSingleScalarResult();
    }
}
