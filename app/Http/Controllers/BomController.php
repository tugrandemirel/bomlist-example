<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\BomChildren;
use App\Models\BomPart;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BomController extends Controller
{
    public function index()
    {
        return view('bom-list');
    }

    public function list(Request $request)
    {
        /**
         *
         * Araba (BOM 1)
         * ├── Motor (BOM 2)
         * │   ├── Piston (Parça 1) - Quantity: 4
         * │   └── Krank (Parça 2) - Quantity: 1
         * ├── Şasi (BOM 3)
         * │   └── Kapı (Parça 3) - Quantity: 4
         * └── Tekerlek (BOM 4)
         * └── Lastik (Parça 4) - Quantity: 4
         */

        $boms = Bom::query()
            ->select('name', 'id')
            ->get();

        $treeData = [];

        foreach ($boms as $bom) {
            // Ana BOM'un çocuklarını al
            $childrenData = $this->getBomChildren($bom->id);

            // Her BOM için ağaç yapısını oluşturma
            $treeData[] = [
                'id' => "node_" . time() . rand(1, 100000) . "_parent" . $bom->id,
                'text' => $bom->name,
                'children' => $childrenData,
            ];
        }
        return response()->json($treeData);
    }
    private function getBomChildren($parentId)
    {
        // Çocuk BOM'ları al
        $children = BomChildren::query()
            ->where('parent_bom_id', $parentId)
            ->join('boms', 'boms.id', '=', 'bom_childrens.child_bom_id')
            ->select('boms.id as id', 'boms.name as text', 'bom_childrens.quantity')
            ->get();

        $childData = [];

        foreach ($children as $child) {
            // Alt BOM'ları al
            $grandchildren = $this->getBomChildren($child->id); // Recursive çağrı

            // Çocuk BOM'u jsTree yapısına ekleme
            $childData[] = [
                'id' => "node_" . time() . rand(1, 100000) . "_parent" . $child->id,
                'text' => $child->text,
                'children' => $grandchildren, // Alt BOM'lar
                'data' => ['quantity' => $child->quantity],
            ];
        }

        // Parçaları al
        $parts = BomPart::query()
            ->where('bom_id', $parentId)
            ->join('parts', 'parts.id', '=', 'bom_parts.part_id')
            ->select('parts.id as id', 'parts.name as text', 'bom_parts.quantity')
            ->get();

        // Parçaları jsTree yapısına ekleme
        foreach ($parts as $part) {
            $childData[] = [
                'id' => "node_" . time() . rand(1, 100000) . "_part" . $part->id,
                'text' => $part->text,
                'children' => [], // Parçalar altında çocukları yok
                'data' => ['quantity' => $part->quantity],
            ];
        }

        return $childData;
    }


    public function addPartToExistingBom(Request $request)
    {
        DB::beginTransaction();
        try {
            // Kullanıcıdan gelen bilgiler
            $selectedBomId = $request->input('selected_bom_id'); // Seçilen BOM ID'si
            $selectedPartId = $request->input('selected_part_id'); // Seçilen parça ID'si

            // Seçilen parçayı al
            $part = Part::findOrFail($selectedPartId);

            // Seçilen BOM'u al
            $selectedBom = Bom::findOrFail($selectedBomId);

            // Üst BOM'ları bul
            $parentBoms = $this->getParentBoms($selectedBom);

            // Yeni BOM oluştur
            $newBom = Bom::create([
                'uuid' => Str::uuid(),
                'name' => 'Ev Kapısı',
                'description' => "Ev Kapısı BOM'u, Kilit eklendi",
            ])->id;

            // Parent BOM'ları ve parçayı yeni BOM'a ekle
            $this->linkBomsToNewBom($parentBoms, $newBom, $part);

            DB::commit();
            return response()->json(['success' => true, 'new_bom_id' => $newBom]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    private function getParentBoms($selectedBom)
    {
        $parentBoms = [];

        // Seçilen BOM'un parent BOM'larını bul
        $bomChildren = BomChildren::where('child_bom_id', $selectedBom->id)->get();

        foreach ($bomChildren as $child) {
            $parentBom = Bom::find($child->parent_bom_id);
            if ($parentBom) {
                $parentBoms[] = $parentBom;
                // Üst BOM'ları eklemek için döngü
                $parentBoms = array_merge($parentBoms, $this->getParentBoms($parentBom));
            }
        }

        return $parentBoms;
    }

    private function linkBomsToNewBom($parentBoms, $newBomId, $part)
    {
        // Parent BOM'ları yeni BOM'a ekle
        foreach ($parentBoms as $parentBom) {
            BomChildren::create([
                'uuid' => Str::uuid(),
                'parent_bom_id' => $newBomId,
                'child_bom_id' => $parentBom->id,
                'quantity' => 1,
            ]);
        }

        // Seçilen parçayı yeni BOM'a ekle
        BomPart::create([
            'uuid' => Str::uuid(),
            'bom_id' => $newBomId,
            'part_id' => $part->id,
            'quantity' => 1,
        ]);
    }
}
