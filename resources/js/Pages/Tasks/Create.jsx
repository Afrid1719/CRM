import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import TextArea from "@/Components/TextArea";
import SelectDropdown from "@/Components/SelectDropdown";

export default function Create({ auth, users, clients, projects, task }) {
    const { data, setData, post, put, processing, errors, wasSuccessful } =
        useForm({
            title: task?.title || "",
            description: task?.description || "",
            deadline: task?.deadline || "",
            assigned_to: task?.assigned_to || "",
            for_client: task?.for_client || "",
            related_to_project: task?.related_to_project || "",
            status: task?.status || "0"
        });

    const submit = (e) => {
        e.preventDefault();

        if (task) {
            put(route("tasks.update", { task: task.id }));
        } else {
            post(route("tasks.store"));
        }
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Tasks
                </h2>
            }
        >
            {typeof task !== "undefined" ? (
                <Head title="Edit Task" />
            ) : (
                <Head title="Create Task" />
            )}

            <div className="py-12">
                <div className="max-w-8xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm sm:rounded-lg">
                        <div className="w-full flex justify-end p-3">
                            <Link
                                as="button"
                                href={route("tasks.index")}
                                className="p-2 border border:border-gray-800 dark:border-white rounded-md font-normal font-sans text-sm"
                            >
                                SHOW ALL TASKS
                            </Link>
                        </div>
                        <div className="p-4">
                            <div className="flex items-center my-4">
                                <h2 className="inline-block font-normal font-sans text-lg py-1 my-4 border-b">
                                    {task
                                        ? `Edit Task - ${task.title}`
                                        : "Create Task"}
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
                            <form onSubmit={submit}>
                                <div>
                                    <InputLabel htmlFor="title" value="Title" />

                                    <TextInput
                                        id="title"
                                        name="title"
                                        value={data.title}
                                        className="mt-1 block w-full"
                                        autoComplete="title"
                                        isFocused={true}
                                        onChange={(e) =>
                                            setData("title", e.target.value)
                                        }
                                        required
                                    />

                                    <InputError
                                        message={errors.title}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="description"
                                        value="Description"
                                    />

                                    <TextArea
                                        id="description"
                                        name="description"
                                        value={data.description}
                                        className="mt-1 block w-full"
                                        autoComplete="description"
                                        onChange={(e) =>
                                            setData(
                                                "description",
                                                e.target.value
                                            )
                                        }
                                        required
                                    />

                                    <InputError
                                        message={errors.description}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="assigned_to"
                                        value="Assign To"
                                    />

                                    <SelectDropdown
                                        key="assigned_to"
                                        id="assigned_to"
                                        name="assigned_to"
                                        className="mt-1 block w-full"
                                        value={data.assigned_to}
                                        onChange={(e) =>
                                            setData(
                                                "assigned_to",
                                                e.target.value
                                            )
                                        }
                                        required
                                    >
                                        <option value="">None</option>
                                        {users.map((user) => (
                                            <option
                                                key={user.id}
                                                value={user.id}
                                            >
                                                {user.name}
                                            </option>
                                        ))}
                                    </SelectDropdown>

                                    <InputError
                                        message={errors.assigned_to}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="for_client"
                                        value="For Client"
                                    />

                                    <SelectDropdown
                                        key="for_client"
                                        id="for_client"
                                        name="for_client"
                                        className="mt-1 block w-full"
                                        value={data.for_client}
                                        onChange={(e) =>
                                            setData(
                                                "for_client",
                                                e.target.value
                                            )
                                        }
                                        required
                                    >
                                        <option value="">None</option>
                                        {clients.map((client) => (
                                            <option
                                                key={client.id}
                                                value={client.id}
                                            >
                                                {client.name}
                                            </option>
                                        ))}
                                    </SelectDropdown>

                                    <InputError
                                        message={errors.for_client}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="related_to_project"
                                        value="Project Belongs To"
                                    />

                                    <SelectDropdown
                                        key="related_to_project"
                                        id="related_to_project"
                                        name="related_to_project"
                                        className="mt-1 block w-full"
                                        value={data.related_to_project}
                                        onChange={(e) =>
                                            setData(
                                                "related_to_project",
                                                e.target.value
                                            )
                                        }
                                        required
                                    >
                                        <option value="">None</option>
                                        {projects.map((project) => (
                                            <option
                                                key={project.id}
                                                value={project.id}
                                            >
                                                {project.title}
                                            </option>
                                        ))}
                                    </SelectDropdown>

                                    <InputError
                                        message={errors.related_to_project}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="status"
                                        value="Status"
                                    />

                                    <SelectDropdown
                                        key="status"
                                        id="status"
                                        name="status"
                                        className="mt-1 block w-full"
                                        value={data.status}
                                        onChange={(e) =>
                                            setData("status", e.target.value)
                                        }
                                        required
                                    >
                                        <option value="0">Open</option>
                                        <option value="1">Completed</option>
                                    </SelectDropdown>

                                    <InputError
                                        message={errors.status}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="flex items-center justify-end mt-4">
                                    <PrimaryButton
                                        className="ms-4"
                                        disabled={processing}
                                    >
                                        Save
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
