namespace App\Repositories;

use App\Models\User;

class UserRepository {
    // Hàm cập nhật thông tin user
    public function update(int $userId, array $data) {
        return User::where('id', $userId)->update($data);
    }

    // Hàm tìm user theo ID
    public function find(int $id) {
        return User::find($id);
    }
}