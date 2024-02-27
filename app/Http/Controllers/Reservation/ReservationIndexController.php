<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationIndexRequest;
use App\Http\Resources\ReservationIndexResource;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

class ReservationIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationIndexRequest $request): Response
    {
        $user = $request->user();

        $builder = $user->reservations()->getQuery();

        $builder->with(['user']);

        $this->filterStartAt($request, $builder);
        $this->filterEndAt($request, $builder);

        $this->sort($request, $builder);

        return ReservationIndexResource::collection($builder->paginate($request->input('per_page')))->toResponse($request);
    }

    public function filterStartAt(ReservationIndexRequest $request, Builder $builder): void
    {
        if ($request->missing('filter.lte_start_at') && $request->missing('filter.gte_start_at')) {
            return;
        }

        $dateFrom = $request->input('filter.gte_start_at');
        $dateTo = $request->input('filter.lte_start_at');

        Reservation::scopeStartAtRange($builder, $dateFrom, $dateTo);
    }

    public function filterEndAt(ReservationIndexRequest $request, Builder $builder): void
    {
        if ($request->missing('filter.lte_end_at') && $request->missing('filter.gte_end_at')) {
            return;
        }

        $dateFrom = $request->input('filter.gte_end_at');
        $dateTo = $request->input('filter.lte_end_at');

        Reservation::scopeEndAtRange($builder, $dateFrom, $dateTo);
    }

    /**
     * Sort query.
     */
    protected function sort(ReservationIndexRequest $request, Builder $builder): void
    {
        if ($request->missing('sort')) {
            return;
        }

        $sorts = $request->input('sort');

        foreach ($sorts as $sort) {
            if (str_starts_with($sort, '-')) {
                $builder->orderByDesc($builder->qualifyColumn(mb_substr($sort, 1)));
            } else {
                $builder->orderBy($builder->qualifyColumn($sort));
            }
        }
    }
}
