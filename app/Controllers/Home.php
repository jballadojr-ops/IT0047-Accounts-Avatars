<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home');
    }

    public function about(): string
    {
        return view('about');
    }

    public function customers(): string
    {
        return view('customers', [
            'customers' => (new CustomerModel())->findAll(),
        ]);
    }

    public function users(): string
    {
        return view('users', [
            'users' => (new UserModel())->findAll(),
        ]);
    }

    public function email(): string
    {
        return view('Email', [
            'emails' => [
                'juan@example.com',
                'maria@example.com',
                'pedro@example.com',
                'ana@example.com',
            ],
        ]);
    }

    // NEW CUSTOMER
    public function newCustomer()
    {
        return view('customer_form', [
            'customer' => null,
            'errors' => [],
        ]);
    }

    public function createCustomer()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return view('customer_form', [
                'customer' => null,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        (new CustomerModel())->insert([
            'full_name' => trim($this->request->getPost('full_name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim($this->request->getPost('phone') ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('customers'))
            ->with('success', 'Customer created successfully.');
    }

    // EDIT CUSTOMER
    public function editCustomer($id)
    {
        $customer = (new CustomerModel())->find($id);

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customer_form', [
            'customer' => $customer,
            'errors' => [],
        ]);
    }

    public function updateCustomer($id)
    {
        $model = new CustomerModel();
        $customer = $model->find($id);

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return view('customer_form', [
                'customer' => array_merge(
                    $customer,
                    $this->request->getPost()
                ),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $model->update($id, [
            'full_name' => trim($this->request->getPost('full_name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim($this->request->getPost('phone') ?? ''),
        ]);

        return redirect()->to(site_url('customers'))
            ->with('success', 'Customer updated successfully.');
    }

    // NEW USER
    public function newUser()
    {
        return view('user_form', [
            'user' => null,
            'errors' => [],
        ]);
    }

    public function createUser()
    {
        $rules = [
            'username' => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return view('user_form', [
                'user' => null,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        (new UserModel())->insert([
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
            'created_at' => date('Y-m-d H:i:s'),
            'avatar' => null,
        ]);

        return redirect()->to(site_url('users'))
            ->with('success', 'User created successfully.');
    }

    // EDIT USER
    public function editUser($id)
    {
        $user = (new UserModel())->find($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('user_form', [
            'user' => $user,
            'errors' => [],
        ]);
    }

    // UPDATE USER AND OPTIONAL AVATAR
    public function updateUser($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = [
            'username' => 'required|max_length[50]|is_unique[users.username,id,' . $id . ']',
            'full_name' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return view('user_form', [
                'user' => array_merge(
                    $user,
                    $this->request->getPost()
                ),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $data = [
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
        ];

        $avatar = $this->request->getFile('avatar');

        // If no new photo is selected, keep the existing avatar.
        if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            $mime = $avatar->getMimeType();

            if (
                ! $avatar->isValid()
                || $avatar->hasMoved()
                || ! in_array($mime, ['image/jpeg', 'image/png'], true)
                || $avatar->getSize() > 2 * 1024 * 1024
                || @getimagesize($avatar->getTempName()) === false
            ) {
                return view('user_form', [
                    'user' => $user,
                    'errors' => [
                        'avatar' => 'Upload a valid JPG or PNG image no larger than 2 MB.',
                    ],
                ]);
            }

            // Check that the required GD functions are available.
            if (
                ! extension_loaded('gd')
                || ! function_exists('imagecreatetruecolor')
                || ! function_exists('imagecopyresampled')
            ) {
                log_message('error', 'GD image functions are unavailable in Apache PHP.');

                return view('user_form', [
                    'user' => $user,
                    'errors' => [
                        'avatar' => 'Image resizing is unavailable. GD must be enabled for Apache PHP.',
                    ],
                ]);
            }

            $directory = FCPATH . 'uploads/avatars/';

            if (
                ! is_dir($directory)
                && ! mkdir($directory, 0755, true)
                && ! is_dir($directory)
            ) {
                throw new \RuntimeException('Could not create the avatar folder.');
            }

            $filename = bin2hex(random_bytes(16))
                . ($mime === 'image/png' ? '.png' : '.jpg');

            $destination = $directory . $filename;
            $sourceImage = false;
            $thumbnail = false;
            $saved = false;

            try {
                // Open the original uploaded image.
                if ($mime === 'image/jpeg') {
                    $sourceImage = imagecreatefromjpeg(
                        $avatar->getTempName()
                    );
                } else {
                    $sourceImage = imagecreatefrompng(
                        $avatar->getTempName()
                    );
                }

                if ($sourceImage === false) {
                    throw new \RuntimeException('Could not open the uploaded image.');
                }

                $sourceWidth = imagesx($sourceImage);
                $sourceHeight = imagesy($sourceImage);

                // Scale the photo to fit within 200 x 200.
                $scale = min(
                    200 / $sourceWidth,
                    200 / $sourceHeight
                );

                $newWidth = max(1, (int) round($sourceWidth * $scale));
                $newHeight = max(1, (int) round($sourceHeight * $scale));

                $thumbnail = imagecreatetruecolor(200, 200);

                if ($thumbnail === false) {
                    throw new \RuntimeException('Could not create the thumbnail.');
                }

                // White background for unused space around the image.
                $white = imagecolorallocate($thumbnail, 255, 255, 255);
                imagefill($thumbnail, 0, 0, $white);

                $x = (int) ((200 - $newWidth) / 2);
                $y = (int) ((200 - $newHeight) / 2);

                imagecopyresampled(
                    $thumbnail,
                    $sourceImage,
                    $x,
                    $y,
                    0,
                    0,
                    $newWidth,
                    $newHeight,
                    $sourceWidth,
                    $sourceHeight
                );

                // Save the resized image to the avatar folder.
                if ($mime === 'image/jpeg') {
                    $saved = imagejpeg($thumbnail, $destination, 85);
                } else {
                    $saved = imagepng($thumbnail, $destination);
                }

                if (! $saved) {
                    throw new \RuntimeException('Could not save the thumbnail.');
                }
            } catch (\Throwable $e) {
                log_message('error', 'Avatar processing failed: {message}', [
                    'message' => $e->getMessage(),
                ]);

                return view('user_form', [
                    'user' => $user,
                    'errors' => [
                        'avatar' => 'Could not resize or save the image. Check the application logs.',
                    ],
                ]);
            } finally {
    // PHP 8+ releases GD image memory automatically.
    // No explicit imagedestroy() calls are needed.
            }

            // Store only the filename in the database.
            $data['avatar'] = $filename;
        }

        $model->update($id, $data);

        return redirect()->to(site_url('users'))
            ->with('success', 'User updated successfully.');
    }
}
