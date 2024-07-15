<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function admin()
    {
        // get all projects with activities status retrasado and deliverables status no completados
        $projects = Project::whereHas('activities', function ($query) {
            $query->where('estado', 'retrasado')
                ->whereHas('deliverables', function ($query) {
                    $query->where('estado', '!=', true);
                });
        })->with(['activities' => function ($query) {
            $query->where('estado', 'retrasado')
                ->with(['deliverables' => function ($query) {
                    $query->where('estado', '!=', true);
                }]);
        }])->get();
        // Preparar datos para el gráfico de pastel

        $dataBar = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Actividades Retrasadas',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];

        foreach ($projects as $project) {
            $dataBar['labels'][] = $project->nombre;
            $dataBar['datasets'][0]['data'][] = $project->activities->count();
        }

        // Preparar datos para el gráfico de pastel
        $retrasadas = 0;
        $noCompletadas = 0;

        foreach ($projects as $project) {
            foreach ($project->activities as $activity) {
                $retrasadas++;
                foreach ($activity->deliverables as $deliverable) {
                    if ($deliverable->estado != true) {
                        $noCompletadas++;
                    }
                }
            }
        }

        $dataPastel = [
            'labels' => ['Actividades Retrasadas', 'Entregables No Completados'],
            'datasets' => [
                [
                    'data' => [$retrasadas, $noCompletadas],
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB']
                ]
            ]
        ];
        return view('admin.dashboard', compact('projects', 'dataBar', 'dataPastel'));
    }

    public function manager()
    {
        return view('manager.dashboard');
    }
}
