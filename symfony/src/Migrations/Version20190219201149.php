<?php
/**
 * This file is part of TechnicalTestSymfony4.
 *
 * @author  Anthony Margerand <anthony.margerand@protonmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link    https://github.com/RealAestan/TechnicalTestSymfony4
 */
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * This migrations create the default schema of our app.
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
final class Version20190219201149 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'This migrations create the default schema of our app';
    }

    /**
     * @param Schema $schema schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName()
            !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $sql = <<<SQL
CREATE TABLE student (
  id INT AUTO_INCREMENT NOT NULL,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  birth_date DATE NOT NULL COMMENT '(DC2Type:date_immutable)',
  PRIMARY KEY(id)
)
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB
SQL;

        $this->addSql($sql);
        $sql = <<<SQL
CREATE TABLE mark (
  id INT AUTO_INCREMENT NOT NULL,
  student_id INT NOT NULL,
  subject VARCHAR(255) NOT NULL,
  result DOUBLE PRECISION NOT NULL,
  INDEX IDX_6674F271CB944F1A (student_id),
  PRIMARY KEY(id)
)
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB
SQL;

        $this->addSql($sql);
        $sql = <<<SQL
ALTER TABLE mark
ADD CONSTRAINT FK_6674F271CB944F1A
FOREIGN KEY (student_id) REFERENCES student (id)
SQL;
        $this->addSql($sql);
    }

    /**
     * @param Schema $schema schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName()
            !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE mark DROP FOREIGN KEY FK_6674F271CB944F1A');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE mark');
    }
}
