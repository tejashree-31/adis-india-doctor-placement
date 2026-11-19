<?php
namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model
{
    protected $table      = 'users1';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sponsor_id', 'left_child', 'right_child', 'name', 'email', 'password', 'created_at'];

    // Function to check and add user to the binary tree
    public function addUser($sponsor_id, $data)
    {
        if ($sponsor_id) {
            $sponsor = $this->find($sponsor_id);
            if ($sponsor) {
                // Check if left or right child is empty
                if ($sponsor['left_child'] === NULL) {
                    echo "hello left";
                    $data['sponsor_id'] = $sponsor_id;
                    $user_id = $this->insert($data);

                    // Update sponsor's left_child
                    $this->update($sponsor_id, ['left_child' => $user_id]);

                    return $user_id;
                } elseif ($sponsor['right_child'] === NULL) {
                     echo "hello right";
                    $data['sponsor_id'] = $sponsor_id;
                    $user_id = $this->insert($data);

                    // Update sponsor's right_child
                    $this->update($sponsor_id, ['right_child' => $user_id]);

                    return $user_id;
                } else {
                    return false; // Sponsor already has two children
                }
            }
        }
        exit();
        // If no sponsor, insert as a root user
        return $this->insert($data);
    }
}
