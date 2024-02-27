<?php

namespace App\Command;

use DateTime;
use Domain\Post\PostManager;
use joshtronic\LoremIpsum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSummaryPostCommand extends Command
{
    protected static $defaultName = 'app:generate-summary-post';
    protected static $defaultDescription = 'Generate simple summary post';
    private PostManager $postManager;
    private LoremIpsum $loremIpsum;

    public function __construct(PostManager $postManager, LoremIpsum $loremIpsum, string $name = null)
    {
        parent::__construct($name);
        $this->postManager = $postManager;
        $this->loremIpsum = $loremIpsum;
    }

    protected function configure(): void
    {
        $this->addArgument("time", null, "Generate report for specific date.", "now");
        $this->addArgument("format", null, "Force to use date format", "Y-m-d");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->postManager->addPost(
            "Summary " . (new DateTime($input->getArgument('time')))
                ->format($input->getArgument('format')),
            $this->loremIpsum->paragraphs(1)
        );

        $output->writeln('The summary post has been added.');

        return Command::SUCCESS;
    }
}
