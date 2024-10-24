<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // Import DB for raw queries
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Str; // For string-related functions
use App\Models\User; // Ensure you include your User model if not already included
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Add a new employee or client
    public function createEmployee(Request $request)
{
    // Validate the request for employee
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => 'required|string|max:15',
        'actions' => 'required|string|max:255',
        'password' => 'required|string', // Required for employee
    ]);

    // Prepare the user data for employee
    $userData = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => 'employee', // Set role as employee
        'actions' => $request->actions,
        'password' => bcrypt($request->password), // Hash the password
        'employee_id' => User::where('role', 'employee')->max('employee_id') + 1, // Increment employee_id
        'client_id' => null, // Set client_id to null
    ];

    // Create the employee user
    $user = User::create($userData);

    return response()->json([
        'message' => 'Employee created successfully',
        'user' => $user,
    ], 201); // Created
}

public function createClient(Request $request)
{
    // Validate the request for client
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => 'required|string|max:15',
        'actions' => 'required|string|max:255',
        // No password needed for client
    ]);

    // Prepare the user data for client
    $userData = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => 'client', // Set role as client
        'actions' => $request->actions,
        'password' => null, // No password for client
        'client_id' => User::where('role', 'client')->max('client_id') + 1, // Increment client_id
        'employee_id' => null, // Set employee_id to null
    ];

    // Create the client user
    $user = User::create($userData);

    return response()->json([
        'message' => 'Client created successfully',
        'user' => $user,
    ], 201); // Created
}

    
    
    
    // Update user data
    public function updateClient(Request $request, $id)
{
    // Find the client by ID or fail
    $client = User::where('role', 'client')->findOrFail($id);

    // Validate the incoming request
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|max:255',
        'phone' => 'sometimes|string|max:15',
        'actions' => 'sometimes|string|max:255', // Validate password with confirmation
    ]);

    // Prepare the data to be updated
    $data = $request->only('name', 'email', 'phone', 'actions');

    // Update the client with only the validated data
    $client->update($data);

    return response()->json([
        'message' => 'Client updated successfully',
        'client' => $client,
    ]);
}

public function updateEmployee(Request $request, $id)
{
    // Find the employee by ID or fail
    $employee = User::where('role', 'employee')->findOrFail($id);

    // Validate the incoming request
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|max:255',
        'phone' => 'sometimes|string|max:15',
        'password' => 'sometimes|nullable', // Validate password with confirmation
        'actions' => 'sometimes|string|max:255', // Validate actions array if provided
    ]);

    // Prevent changing role to owner if one already exists
    if (isset($request->role) && $request->role === 'owner' && User::where('role', 'owner')->exists()) {
        throw ValidationException::withMessages(['role' => 'An owner already exists.']);
    }

    // Prepare the data to be updated
    $data = $request->only('name', 'email', 'phone', 'actions');

    // If a new password is provided, hash it and add to the data array
    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    // Update the employee with only the validated data
    $employee->update($data);

    return response()->json([
        'message' => 'Employee updated successfully',
        'employee' => $employee,
    ]);
}

public function destroyClient($id)
{
    // Find the client by ID and role or fail
    $client = User::where('role', 'client')->findOrFail($id);
    
    // Delete the client
    $client->delete();

    return response()->json([
        'message' => 'Client deleted successfully',
    ]);
}

public function destroyEmployee($id)
{
    // Find the employee by ID and role or fail
    $employee = User::where('role', 'employee')->findOrFail($id);
    
    // Delete the employee
    $employee->delete();

    return response()->json([
        'message' => 'Employee deleted successfully',
    ]);
}


    // Get all users
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'phone', 'actions')->get();
    
        return response()->json([
            'users' => $users,
        ]);
    }
    

    // Get user by ID
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'user' => $user,
        ]);
    }

     // Delete a user
     public function destroy($id)
     {
         $user = User::findOrFail($id);
         $user->delete();
 
         return response()->json([
             'message' => 'User deleted successfully',
         ]);
     }

    // Function to return all employees
    public function getEmployees()
    {
        $employees = User::where('role', 'employee')->get()->makeHidden(['password']);
        return response()->json($employees);
    }

    // Function to return all clients
    public function getClients()
    {
        $clients = User::where('role', 'client')->get();
        return response()->json($clients);
    }

    // Function to return a specific employee by ID
    public function getEmployeeById($id)
    {
        $employee = User::where('id', $id)->where('role', 'employee')->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->makeHidden(['password']);
        return response()->json($employee);
    }

    // Function to return a specific client by ID
    public function getClientById($id)
    {
        $client = User::where('id', $id)->where('role', 'client')->first();

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client);
    }
}
