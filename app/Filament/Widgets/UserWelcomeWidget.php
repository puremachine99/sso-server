<?php

namespace App\Filament\Widgets;

use App\Models\HcpmUser;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class UserWelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.user-welcome-widget';
    protected static ?int $sort = -3;

    public function getUser()
    {
        return Auth::user();
    }

    /**
     * Ambil data user HCPM by email + relasi jobTitles.
     */
    public function getHcpmUser(): ?HcpmUser
    {
        $email = $this->getUser()?->email;
        if (! $email) {
            return null;
        }

        return HcpmUser::query()
            ->with('jobTitles')
            ->where('email', $email)
            ->first();
    }

    /**
     * Siapkan daftar badge (label + warna) untuk ditampilkan di view.
     * - Fungsional => gray
     * - Struktural/Manajerial => primary (biru)
     */
    public function jobBadges(): array
    {
        $hcpm = $this->getHcpmUser();
        if (! $hcpm) {
            return [];
        }

        $badges = [];

        // Manajerial/Struktural (pakai 'primary')
        $managerial = $hcpm->jobTitles
            ->first(fn ($jt) => in_array(strtolower($jt->jenis_jabatan ?? ''), ['struktural', 'manajerial']));

        if ($managerial) {
            $label = $managerial->nama_jabatan
                ?? $managerial->job_title
                ?? 'Manajerial';

            $badges[] = [
                'label' => $label,
                'color' => 'primary',   // biru (ikut theme Filament)
            ];
        }

        // Fungsional (pakai 'gray')
        $fungsional = $hcpm->jobTitles
            ->first(fn ($jt) => strtolower($jt->jenis_jabatan ?? '') === 'fungsional');

        if ($fungsional) {
            $label = $fungsional->nama_jabatan
                ?? $fungsional->job_title
                ?? 'Fungsional';

            $badges[] = [
                'label' => $label,
                'color' => 'gray',
            ];
        }

        return $badges;
    }
}
