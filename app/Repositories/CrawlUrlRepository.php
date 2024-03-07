<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\CrawlUrlRepositoryInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrawlUrlRepository implements CrawlUrlRepositoryInterface
{
    private string|null $_tableName = null;

    /**
     * @return string
     */
    public function getTableName(): string
    {
        if ($this->_tableName) {
            return $this->_tableName;
        }
        $version = date('Y_m_d');
        $this->_tableName = self::TBL_NAME . '_' . $version;
        return $this->_tableName;
    }

    protected function getDBConnection(): \Illuminate\Database\Query\Builder
    {
        return DB::table($this->getTableName());
    }

    /**
     * @return void
     */
    public function createTableIfNotExist(): void
    {
        if (!Schema::hasTable($this->getTableName())) {
            Schema::create($this->getTableName(), function (Blueprint $table) {
                $table->increments('id');
                $table->string("url")->unique();
                $table->tinyInteger("done")->default(0);
            });
        }
    }

    /**
     * @return string|null
     */
    public function getAndPickFirstNonProcessedUrl(): string | null
    {
        return $this->getDBConnection()->where('done', '=', 0)->first()?->url;
    }

    /**
     * @param string $url
     * @return void
     */
    public function markAsDone(string $url): void
    {
        $this->getDBConnection()->where('url', $url)->update(['done' => 1]);
    }

    /**
     * @param array|string[] $urls
     * @return void
     */
    public function insertUrls(array $urls): void
    {
        foreach ($urls as $url) {
            try {
                $this->getDBConnection()->insert([
                    'url' => $url,
                    'done' => 0
                ]);
            } catch (\Exception $e) {
                // TODO: Logging error
            }
        }
    }
}
