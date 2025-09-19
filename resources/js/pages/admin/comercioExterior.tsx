import Dashboard from '@/pages/admin/dashboard';
import { useForm, usePage } from '@inertiajs/react';
import { useEffect, useMemo, useState } from 'react';
import { Toaster, toast } from 'react-hot-toast';

/**
 * Smaller, composable components to remove repetition
 */
const SectionHeader = ({ children }) => (
    <h2 className="border-primary-orange text-primary-orange text-bold col-span-2 w-full border-b-2 text-2xl">{children}</h2>
);

const FieldShell = ({ label, htmlFor, error, children }) => (
    <div className="w-full">
        <label htmlFor={htmlFor} className="block text-lg font-medium text-gray-900">
            {label}
        </label>
        <div className="mt-2">
            <div
                className={`flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 ${
                    error ? 'outline-red-500' : 'outline-gray-300'
                } focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600`}
            >
                <div className="shrink-0 text-base text-gray-500 select-none sm:text-sm/6" />
                {children}
            </div>
            {error && <p className="mt-2 text-sm text-red-600">{error}</p>}
        </div>
    </div>
);

const TextInput = ({ name, label, data, setData, errors, id = name, type = 'text' }) => (
    <FieldShell label={label} htmlFor={id} error={errors?.[name]}>
        <input
            value={data?.[name] ?? ''}
            onChange={(ev) => setData(name, ev.target.value)}
            id={id}
            name={name}
            type={type}
            className="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
        />
    </FieldShell>
);

const ImagePicker = ({ name, label, previewUrl, data, setData }) => (
    <div className="col-span-2 flex flex-row justify-between gap-5">
        <div className="w-full">
            <label htmlFor={name} className="block text-lg font-medium text-gray-900">
                {label}
            </label>
            <div className="mt-2 flex justify-between rounded-lg border shadow-lg">
                <div className="h-[200px] w-1/2 bg-[rgba(0,0,0,0.2)]">
                    {previewUrl ? (
                        <img className="h-full w-full rounded-md object-cover" src={previewUrl} alt="" />
                    ) : (
                        <div className="flex h-full w-full items-center justify-center text-sm text-gray-500">Sin imagen</div>
                    )}
                </div>
                <div className="flex w-1/2 items-center justify-center">
                    <div className="h-fit items-center self-center text-center">
                        <div className="relative mt-4 flex flex-col items-center text-sm/6 text-gray-600">
                            <label htmlFor={name} className="bg-primary-red relative cursor-pointer rounded-md px-2 py-1 font-semibold text-black">
                                <span>Cambiar Imagen</span>
                                <input
                                    id={name}
                                    name={name}
                                    onChange={(e) => setData(name, e.target.files?.[0])}
                                    type="file"
                                    accept="image/*"
                                    className="sr-only"
                                />
                            </label>
                            <p className="absolute top-10 max-w-[200px] break-words">{data?.[name]?.name}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
);

// Nuevo: selector que acepta imagen o video con preview automática
const MediaPicker = ({ name, label, previewUrl, data, setData }) => {
    const [localPreview, setLocalPreview] = useState(null);
    const file = data?.[name];

    useEffect(() => {
        if (file instanceof File) {
            const objUrl = URL.createObjectURL(file);
            setLocalPreview(objUrl);
            return () => URL.revokeObjectURL(objUrl);
        }
        setLocalPreview(null);
    }, [file]);

    const isVideoUrl = (url) => /\.(mp4|webm|ogg|m4v|mov)$/i.test(url ?? '');
    const fileIsVideo = file instanceof File && file.type?.startsWith('video/');
    const effectiveUrl = localPreview || previewUrl || '';
    const showVideo = fileIsVideo || isVideoUrl(effectiveUrl);

    return (
        <div className="col-span-2 flex flex-row justify-between gap-5">
            <div className="w-full">
                <label htmlFor={name} className="block text-lg font-medium text-gray-900">
                    {label}
                </label>
                <div className="mt-2 flex justify-between rounded-lg border shadow-lg">
                    <div className="h-[200px] w-1/2 bg-[rgba(0,0,0,0.2)]">
                        {effectiveUrl ? (
                            showVideo ? (
                                <video className="h-full w-full rounded-md object-cover" src={effectiveUrl} controls />
                            ) : (
                                <img className="h-full w-full rounded-md object-cover" src={effectiveUrl} alt="" />
                            )
                        ) : (
                            <div className="flex h-full w-full items-center justify-center text-sm text-gray-500">Sin media</div>
                        )}
                    </div>
                    <div className="flex w-1/2 items-center justify-center">
                        <div className="h-fit items-center self-center text-center">
                            <div className="relative mt-4 flex flex-col items-center text-sm/6 text-gray-600">
                                <label
                                    htmlFor={name}
                                    className="bg-primary-red relative cursor-pointer rounded-md px-2 py-1 font-semibold text-black"
                                >
                                    <span>Cambiar Imagen/Video</span>
                                    <input
                                        id={name}
                                        name={name}
                                        onChange={(e) => setData(name, e.target.files?.[0])}
                                        type="file"
                                        accept="image/*,video/*"
                                        className="sr-only"
                                    />
                                </label>
                                <p className="absolute top-10 max-w-[200px] break-words">{file?.name}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default function ComercioExterior() {
    const { banner, titulos } = usePage().props;

    // Single source of truth: all fields that exist in the form
    const initialData = useMemo(
        () => ({
            // Sección 1
            title_seccion_uno_es: banner?.title_seccion_uno_es ?? '',
            title_seccion_uno_en: banner?.title_seccion_uno_en ?? '',
            text_seccion_uno_es: banner?.text_seccion_uno_es ?? '',
            text_seccion_uno_en: banner?.text_seccion_uno_en ?? '',

            // Sección 2
            title_seccion_dos_es: banner?.title_seccion_dos_es ?? '',
            title_seccion_dos_en: banner?.title_seccion_dos_en ?? '',
            text_seccion_dos_es: banner?.text_seccion_dos_es ?? '',
            text_seccion_dos_en: banner?.text_seccion_dos_en ?? '',

            title_seccion_tres_es: banner?.title_seccion_tres_es ?? '',
            title_seccion_tres_en: banner?.title_seccion_tres_en ?? '',
            text_seccion_tres_es: banner?.text_seccion_tres_es ?? '',
            text_seccion_tres_en: banner?.text_seccion_tres_en ?? '',
        }),
        [banner, titulos],
    );

    const { data, setData, errors, processing, post, reset } = useForm(initialData);

    useEffect(() => {
        setData(initialData);
    }, [initialData]);

    const TEXT_FIELDS = [
        // Banner principal

        { name: 'title_seccion_uno_es', label: 'Título (Español)' },
        { name: 'title_seccion_uno_en', label: 'Título (Inglés)' },
        { name: 'text_seccion_uno_es', label: 'Texto (Español)' },
        { name: 'text_seccion_uno_en', label: 'Texto (Inglés)' },
        // Sección 2
        { name: 'title_seccion_dos_es', label: 'Título (Español)' },
        { name: 'title_seccion_dos_en', label: 'Título (Inglés)' },
        { name: 'text_seccion_dos_es', label: 'Texto (Español)' },
        { name: 'text_seccion_dos_en', label: 'Texto (Inglés)' },

        //seccion 3
        { name: 'title_seccion_tres_es', label: 'Título (Español)' },
        { name: 'title_seccion_tres_en', label: 'Título (Inglés)' },
        { name: 'text_seccion_tres_es', label: 'Texto (Español)' },
        { name: 'text_seccion_tres_en', label: 'Texto (Inglés)' },
    ];

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route('admin.comercio-exterior.update'), {
            preserveScroll: true,
            forceFormData: true, // ensure file uploads are sent as FormData
            onSuccess: () => {
                toast.success('Banner actualizado correctamente');
                reset();
            },
            onError: () => {
                toast.error('Error al actualizar el banner');
            },
        });
    };

    return (
        <Dashboard>
            <Toaster />
            <form onSubmit={handleSubmit} className="grid h-fit grid-cols-2 justify-between gap-5 p-6">
                <SectionHeader>Sección 1</SectionHeader>

                {/* Sección 1 - textos */}
                {TEXT_FIELDS.slice(0, 4).map((f) => (
                    <TextInput key={f.name} {...f} data={data} setData={setData} errors={errors} />
                ))}

                <SectionHeader>Sección 2</SectionHeader>

                {/* Sección 1 - textos */}
                {TEXT_FIELDS.slice(4, 8).map((f) => (
                    <TextInput key={f.name} {...f} data={data} setData={setData} errors={errors} />
                ))}

                {/* Sección 1 - imagen */}
                <ImagePicker name="image_seccion_dos" label="Imagen" previewUrl={banner?.image_seccion_dos} data={data} setData={setData} />

                <SectionHeader>Sección 3</SectionHeader>

                {/* Sección 2 - textos */}
                {TEXT_FIELDS.slice(8, 12).map((f) => (
                    <TextInput key={f.name} {...f} data={data} setData={setData} errors={errors} />
                ))}

                <ImagePicker name="image_seccion_tres" label="Imagen" previewUrl={banner?.image_seccion_tres} data={data} setData={setData} />

                <ImagePicker
                    name="image_seccion_tres_dos"
                    label="Icono 1"
                    previewUrl={banner?.image_seccion_tres_dos}
                    data={data}
                    setData={setData}
                />

                <ImagePicker
                    name="image_seccion_tres_tres"
                    label="Icono 2"
                    previewUrl={banner?.image_seccion_tres_tres}
                    data={data}
                    setData={setData}
                />

                <div className="flex items-center justify-start gap-x-6">
                    <button
                        type="submit"
                        disabled={processing}
                        className={`bg-primary-orange rounded-full px-3 py-2 text-sm font-semibold text-white shadow-sm transition-transform hover:scale-95 ${
                            processing ? 'cursor-not-allowed opacity-70' : ''
                        }`}
                    >
                        {processing ? 'Actualizando...' : 'Actualizar'}
                    </button>
                </div>
            </form>
        </Dashboard>
    );
}
