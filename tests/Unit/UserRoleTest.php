<?php

namespace Tests\Unit;

use App\Models\Pendaftaran;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function test_each_primary_role_redirects_to_its_own_dashboard(): void
    {
        $this->assertSame('admin.dashboard', (new User(['role' => 'admin']))->dashboardRoute());
        $this->assertSame('mentor.monitoring.index', (new User(['role' => 'mentor']))->dashboardRoute());
        $this->assertSame('mahasiswa.dashboard', (new User(['role' => 'mahasiswa']))->dashboardRoute());
    }

    public function test_role_labels_match_the_three_primary_roles(): void
    {
        $this->assertSame('Penyelenggara Beasiswa', (new User(['role' => 'admin']))->roleLabel());
        $this->assertSame('Mentor', (new User(['role' => 'mentor']))->roleLabel());
        $this->assertSame('Mahasiswa', (new User(['role' => 'mahasiswa']))->roleLabel());
    }

    public function test_revision_status_has_a_human_readable_label(): void
    {
        $this->assertSame('Perlu revisi berkas', Pendaftaran::label('perlu_revisi'));
    }
}
