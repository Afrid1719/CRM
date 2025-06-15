import { useState, useRef, startTransition, useEffect } from "react";
import InputError from "./InputError";
import InputLabel from "./InputLabel";
import FileInput from "./FileInput";
import { router } from "@inertiajs/react";

export default function AttachmentsInput({
    id,
    name,
    data,
    setData,
    error,
    label,
    multiple,
    attachedFiles,
    setAttachedFiles,
    clearInput = false
}) {
    const [fileNames, setFileNames] = useState(data[name]);
    const fileInputRef = useRef(null);

    useEffect(() => {
        if (clearInput && fileNames) {
            for (let i = 0; i < fileNames.length; i++) {
                setFileNames(null);
                setData(name, null);
                const dt = new DataTransfer();
                fileInputRef.current.files = dt.files;
            }
        }
    }, [clearInput]);

    const handleChange = (e) => {
        const files = Array.from(e.target.files);
        setData(name, files);

        // Set the file name
        if (files.length > 0) {
            setFileNames(files.map((file) => file.name));
        } else {
            setFileNames(null); // Reset if no file is selected
        }
    };

    const handleRemoveFile = (index) => {
        // Remove the file name from the fileNames state
        setFileNames((prev) => prev.filter((_, i) => i !== index));

        // Remove the file from the data object
        const updatedFiles = data[name].filter((_, i) => i !== index);
        setData(name, updatedFiles);

        // Update the file input's value to reflect the changes
        const dataTransfer = new DataTransfer();
        updatedFiles.forEach((file) => dataTransfer.items.add(file));
        fileInputRef.current.files = dataTransfer.files;
    };

    const handleRemoveAttachedFiles = (id) => {
        router.delete(route("attachments.destroy", id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                setAttachedFiles((prev) =>
                    prev.filter((file) => file.id !== id)
                );
            },
            onError: (error) => {
                alert("Error removing attachment");
                console.error("Error removing attachment:", error);
            }
        });
    };

    return (
        <div className="flex flex-col gap-1">
            <InputLabel value={label} />
            {attachedFiles.length > 0 && (
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-2">
                    {attachedFiles.map((file) => (
                        <div
                            key={file.id}
                            className="border p-4 rounded-md shadow-sm"
                        >
                            <a
                                href={file.url || "#"}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-blue-600 hover:underline block"
                            >
                                {file.filename || `File ${file.id}`}
                            </a>
                            <button
                                type="button"
                                onClick={() =>
                                    handleRemoveAttachedFiles(file.id)
                                }
                                className="text-red-600 hover:underline mt-2"
                            >
                                Remove
                            </button>
                        </div>
                    ))}
                </div>
            )}
            <FileInput
                id={id}
                name={name}
                onChange={handleChange}
                className="block w-full pl-1 pr-3 py-2"
                multiple={multiple}
                ref={fileInputRef}
            />
            {fileNames && fileNames.length > 0 && (
                <div className="mt-2 text-sm text-gray-600">
                    <p className="font-medium">Selected Files:</p>
                    <ul className="list-disc list-inside">
                        {fileNames.map((fileName, index) => (
                            <li key={index}>
                                {fileName}
                                <button className="align-middle">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        className="h-6 w-6 text-red-500 ml-2 cursor-pointer"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        onClick={() => handleRemoveFile(index)}
                                    >
                                        <path
                                            fillRule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.293-9.293a1 1 0 00-1.414 0L10 9.586l-.879-.879a1 1 0 00-1.414 1.414l.879.879-.879.879a1 1 0 001.414 1.414l.879-.879.879.879a1 1 0 001.414-1.414l-.879-.879.879-.879a1 1 0 000-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </li>
                        ))}
                    </ul>
                </div>
            )}
            <InputError message={error} className="mt-2" />
        </div>
    );
}
