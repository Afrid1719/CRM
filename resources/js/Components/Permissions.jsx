import { useForm } from "@inertiajs/react";
import PrimaryButton from "./PrimaryButton";

const Permissions = ({ permissions, actions, user }) => {
    const { data, setData, put, wasSuccessful, processing } = useForm({
        permissions: permissions ? permissions : []
    });

    const savePermissions = (e) => {
        e.preventDefault();

        put(route("users.permissions.update", user.id), {
            preserveScroll: true,
            data
        });
    };

    const handlePermissionChange = (e, resourceId, action) => {
        const checked = e.target.checked;
        setData((prevData) => {
            const idx = prevData.permissions.findIndex(
                (r) => r.id === resourceId
            );
            if (idx === -1) return prevData;

            // Only update if value actually changes
            if (prevData.permissions[idx].permissions[action] === checked)
                return prevData;

            const updatedPermissions = [...prevData.permissions];
            updatedPermissions[idx] = {
                ...updatedPermissions[idx],
                permissions: {
                    ...updatedPermissions[idx].permissions,
                    [action]: checked
                }
            };
            return { ...prevData, permissions: updatedPermissions };
        });
    };

    if (data.permissions.length === 0 || !user) {
        // When creating a new user, permissions will not be available
        return (
            <div className="w-full">
                <div className="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm sm:rounded-lg p-4">
                    <p className="text-center">No permissions available.</p>
                </div>
            </div>
        );
    }

    return (
        <div className="w-full">
            <div className="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm sm:rounded-lg p-4">
                <div className="flex my-4">
                    <h2 className="inline-block font-normal font-sans text-lg py-1 border-b">
                        Permissions
                    </h2>
                    <div className="inline-block p-2 text-green-600">
                        {wasSuccessful && (
                            <div className="flex items-center gap-x-1">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    x="0px"
                                    y="0px"
                                    width="100"
                                    height="100"
                                    viewBox="0 0 48 48"
                                    className="w-6 h-6"
                                >
                                    <path
                                        fill="#c8e6c9"
                                        d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"
                                    ></path>
                                    <path
                                        fill="#4caf50"
                                        d="M34.586,14.586l-13.57,13.586l-5.602-5.586l-2.828,2.828l8.434,8.414l16.395-16.414L34.586,14.586z"
                                    ></path>
                                </svg>
                                {"Saved"}
                            </div>
                        )}
                    </div>
                </div>
                <form className="rounded-md" onSubmit={savePermissions}>
                    <table className="min-w-full border border-gray-300 rounded-md">
                        <thead>
                            <tr>
                                <th className="px-4 py-2 text-left border-b">
                                    Resource
                                </th>
                                {Object.entries(actions).map(([action]) => (
                                    <th
                                        key={`${action}-header`}
                                        scope="col"
                                        className="px-4 py-2 text-left border-b capitalize"
                                    >
                                        {action}
                                    </th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {data.permissions.map((r) => (
                                <tr
                                    className="border-b"
                                    key={`${r.name}-${r.id}`}
                                >
                                    <td className="px-4 py-2 border-b">
                                        {r.name}
                                    </td>
                                    {Object.entries(r.permissions).map(
                                        ([action, value]) => (
                                            <td
                                                key={`${action}-cell-${r.id}`}
                                                className="px-4 py-2 border-b"
                                            >
                                                <div className="inline-flex items-center align-middle">
                                                    <label className="flex items-center cursor-pointer relative">
                                                        <input
                                                            type="checkbox"
                                                            checked={value}
                                                            onChange={(e) =>
                                                                handlePermissionChange(
                                                                    e,
                                                                    r.id,
                                                                    action
                                                                )
                                                            }
                                                            className="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-blue-600 checked:border-blue-600"
                                                            id={`${action}-cell-${r.id}`}
                                                        />
                                                        <span className="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                className="h-3.5 w-3.5"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                                stroke="currentColor"
                                                                strokeWidth="1"
                                                            >
                                                                <path
                                                                    fillRule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clipRule="evenodd"
                                                                ></path>
                                                            </svg>
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        )
                                    )}
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <div className="flex items-center justify-end mt-4">
                        <PrimaryButton className="ms-4" disabled={processing}>
                            Save
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Permissions;
