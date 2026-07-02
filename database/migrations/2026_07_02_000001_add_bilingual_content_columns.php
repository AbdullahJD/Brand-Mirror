<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addStringTranslations('categories', ['name']);
        $this->addTextTranslations('categories', ['description']);
        $this->copyAndDrop('categories', ['name', 'description']);

        $this->addStringTranslations('products', ['name']);
        $this->addTextTranslations('products', ['description']);
        $this->addJsonTranslations('products', ['additional_information']);
        $this->copyAndDrop('products', ['name', 'description', 'additional_information']);

        $this->addStringTranslations('banners', ['title']);
        $this->copyAndDrop('banners', ['title']);

        $this->addStringTranslations('attributes', ['name']);
        $this->copyAndDrop('attributes', ['name']);

        $this->addStringTranslations('attribute_values', ['value']);
        $this->copyAndDrop('attribute_values', ['value']);
    }

    public function down(): void
    {
        $this->restoreStringColumns('categories', ['name']);
        $this->restoreTextColumns('categories', ['description']);
        $this->copyBackAndDropTranslations('categories', ['name', 'description']);

        $this->restoreStringColumns('products', ['name']);
        $this->restoreTextColumns('products', ['description']);
        $this->restoreJsonColumns('products', ['additional_information']);
        $this->copyBackAndDropTranslations('products', ['name', 'description', 'additional_information']);

        $this->restoreStringColumns('banners', ['title']);
        $this->copyBackAndDropTranslations('banners', ['title']);

        $this->restoreStringColumns('attributes', ['name']);
        $this->copyBackAndDropTranslations('attributes', ['name']);

        $this->restoreStringColumns('attribute_values', ['value']);
        $this->copyBackAndDropTranslations('attribute_values', ['value']);
    }

    private function addStringTranslations(string $tableName, array $columns): void
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
            foreach ($columns as $column) {
                $this->addTranslatedColumn($table, $tableName, $column, 'string');
            }
        });
    }

    private function addTextTranslations(string $tableName, array $columns): void
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
            foreach ($columns as $column) {
                $this->addTranslatedColumn($table, $tableName, $column, 'text');
            }
        });
    }

    private function addJsonTranslations(string $tableName, array $columns): void
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
            foreach ($columns as $column) {
                $this->addTranslatedColumn($table, $tableName, $column, 'json');
            }
        });
    }

    private function addTranslatedColumn(Blueprint $table, string $tableName, string $column, string $type): void
    {
        foreach (['ar', 'en'] as $locale) {
            $translatedColumn = "{$column}_{$locale}";

            if (! Schema::hasColumn($tableName, $translatedColumn)) {
                $table->{$type}($translatedColumn)->nullable();
            }
        }
    }

    private function copyAndDrop(string $tableName, array $columns): void
    {
        foreach ($columns as $column) {
            if (Schema::hasColumn($tableName, $column)) {
                DB::table($tableName)->update([
                    "{$column}_ar" => DB::raw($column),
                    "{$column}_en" => DB::raw($column),
                ]);
            }
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
            $dropColumns = array_values(array_filter(
                $columns,
                fn (string $column) => Schema::hasColumn($tableName, $column)
            ));

            if ($dropColumns !== []) {
                $table->dropColumn($dropColumns);
            }
        });
    }

    private function restoreStringColumns(string $tableName, array $columns): void
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
            foreach ($columns as $column) {
                if (! Schema::hasColumn($tableName, $column)) {
                    $table->string($column)->nullable();
                }
            }
        });
    }

    private function restoreTextColumns(string $tableName, array $columns): void
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
            foreach ($columns as $column) {
                if (! Schema::hasColumn($tableName, $column)) {
                    $table->text($column)->nullable();
                }
            }
        });
    }

    private function restoreJsonColumns(string $tableName, array $columns): void
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
            foreach ($columns as $column) {
                if (! Schema::hasColumn($tableName, $column)) {
                    $table->json($column)->nullable();
                }
            }
        });
    }

    private function copyBackAndDropTranslations(string $tableName, array $columns): void
    {
        foreach ($columns as $column) {
            if (Schema::hasColumn($tableName, $column)) {
                DB::table($tableName)->update([
                    $column => DB::raw("COALESCE({$column}_en, {$column}_ar)"),
                ]);
            }
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
            $dropColumns = [];

            foreach ($columns as $column) {
                foreach (['ar', 'en'] as $locale) {
                    $translatedColumn = "{$column}_{$locale}";

                    if (Schema::hasColumn($tableName, $translatedColumn)) {
                        $dropColumns[] = $translatedColumn;
                    }
                }
            }

            if ($dropColumns !== []) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
