<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    protected function getNotificationData()
    {
        $data = [
            'unread_notifications_count' => 0,
            'recent_notifications' => []
        ];

        if (session()->get('logged_in')) {
            $userId = session()->get('user_id');
            $userType = session()->get('user_type');
            $notificationModel = new \App\Models\NotificationModel();
            $today = date('Y-m-d');

            // Auto-generate overdue notification for students
            if ($userType === 'siswa') {
                $peminjamanModel = new \App\Models\PeminjamanModel();
                $totalJatuhTempo = $peminjamanModel->where('user_id', $userId)
                                                   ->where('status', 'dipinjam')
                                                   ->where('tanggal_kembali <', $today)
                                                   ->countAllResults();

                if ($totalJatuhTempo > 0) {
                    $existingNotif = $notificationModel->where('user_id', $userId)
                                                      ->where('title', 'Buku Jatuh Tempo')
                                                      ->where('DATE(created_at)', $today)
                                                      ->first();
                    
                    // Estimate current fine
                    $overdueBooks = $peminjamanModel->where('user_id', $userId)
                                                   ->where('status', 'dipinjam')
                                                   ->where('tanggal_kembali <', $today)
                                                   ->findAll();
                    $totalDendaEst = 0;
                    $dendaPerHari = 1000;
                    foreach ($overdueBooks as $book) {
                        $diff = (new \DateTime($today))->diff(new \DateTime($book['tanggal_kembali']));
                        $totalDendaEst += $diff->days * $dendaPerHari;
                    }

                    $message = "Anda memiliki $totalJatuhTempo buku yang sudah jatuh tempo. Estimasi denda saat ini: Rp " . number_format($totalDendaEst, 0, ',', '.') . ". Harap segera dikembalikan!";

                    if (!$existingNotif) {
                        $notificationModel->save([
                            'user_id' => $userId,
                            'title'   => 'Buku Jatuh Tempo',
                            'message' => $message,
                            'type'    => 'warning'
                        ]);
                    } else if ($existingNotif['is_read'] == 0) {
                        // Update message if not read to keep fine estimation current
                        $notificationModel->update($existingNotif['id'], ['message' => $message]);
                    }
                }
                $data['total_overdue_siswa'] = $totalJatuhTempo;

                // Auto-generate unpaid fine notification
                $unpaidFines = $peminjamanModel->where('user_id', $userId)
                                               ->where('status', 'dikembalikan')
                                               ->where('denda >', 0)
                                               ->where('is_denda_lunas', 0)
                                               ->findAll();
                
                if (count($unpaidFines) > 0) {
                    $totalUnpaid = array_sum(array_column($unpaidFines, 'denda'));
                    $existingFineNotif = $notificationModel->where('user_id', $userId)
                                                          ->where('title', 'Tagihan Denda')
                                                          ->where('DATE(created_at)', $today)
                                                          ->first();
                    
                    $msgFine = "Anda memiliki tagihan denda sebesar Rp " . number_format($totalUnpaid, 0, ',', '.') . " dari buku yang sudah dikembalikan. Harap segera melunasi di petugas perpustakaan.";
                    
                    if (!$existingFineNotif) {
                        $notificationModel->save([
                            'user_id' => $userId,
                            'title'   => 'Tagihan Denda',
                            'message' => $msgFine,
                            'type'    => 'danger'
                        ]);
                    } else if ($existingFineNotif['is_read'] == 0) {
                        $notificationModel->update($existingFineNotif['id'], ['message' => $msgFine]);
                    }
                }
            }
            
            $data['unread_notifications_count'] = $notificationModel->where('user_id', $userId)
                                                                   ->where('is_read', 0)
                                                                   ->countAllResults();
            $data['recent_notifications'] = $notificationModel->where('user_id', $userId)
                                                              ->orderBy('created_at', 'DESC')
                                                              ->findAll(5);

            // Fetch global overdue count for admin sidebar
            if ($userType === 'admin') {
                $peminjamanModel = new \App\Models\PeminjamanModel();
                $data['total_overdue_global'] = $peminjamanModel->where('status', 'dipinjam')
                                                                ->where('tanggal_kembali <', $today)
                                                                ->countAllResults();
            }
        }

        return $data;
    }
}
