import { faPen, faTrash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { useForm } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { useEffect, useState } from 'react';
import toast from 'react-hot-toast';
import CustomReactQuill from './CustomReactQuill';

export default function LineasAdminRow({ linea }) {
    const [edit, setEdit] = useState(false);

    const updateForm = useForm({
        name: linea?.name,
        order: linea?.order,
        text: linea?.text,
        id: linea?.id,
    });

    const [text, setText] = useState(linea?.text);

    useEffect(() => {
        updateForm.setData('text', text);
    }, [text]);

    const handleUpdate = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        updateForm.post(route('admin.lineas.update'), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Linea actualizada correctamente');
                setEdit(false);
            },
            onError: (errors) => {
                toast.error('Error al actualizar linea');
                console.log(errors);
            },
        });
    };

    const deleteLinea = () => {
        if (confirm('¿Estas seguro de eliminar esta linea?')) {
            updateForm.delete(route('admin.lineas.destroy'), {
                preserveScroll: true,
                onSuccess: () => {
                    toast.success('Linea eliminada correctamente');
                },
                onError: (errors) => {
                    toast.error('Error al eliminar linea');
                    console.log(errors);
                },
            });
        }
    };

    return (
        <tr className={`border text-black odd:bg-gray-100 even:bg-white`}>
            <td className="align-middle">{linea?.order}</td>
            <td className="h-[90px] align-middle">{linea?.name}</td>
            <td className="max-w-[100px]">
                <div className="line-clamp-3 overflow-hidden break-words" dangerouslySetInnerHTML={{ __html: linea?.text }} />
            </td>
            <td className="flex h-[90px] items-center justify-center">
                <img className="w-[100px]" src={`/storage/${linea?.image}`} alt="" />
            </td>

            <td className="w-[140px] text-center">
                <div className="flex flex-row justify-center gap-3">
                    <button onClick={() => setEdit(true)} className="h-10 w-10 rounded-md border border-blue-500 px-2 py-1 text-white">
                        <FontAwesomeIcon icon={faPen} size="lg" color="#3b82f6" />
                    </button>
                    <button onClick={deleteLinea} className="h-10 w-10 rounded-md border border-red-500 px-2 py-1 text-white">
                        <FontAwesomeIcon icon={faTrash} size="lg" color="#fb2c36" />
                    </button>
                </div>
            </td>
            <AnimatePresence>
                {edit && (
                    <motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        className="fixed top-0 left-0 z-50 flex h-full w-full items-center justify-center bg-black/50 text-left"
                    >
                        <form onSubmit={handleUpdate} method="POST" className="text-black">
                            <div className="w-[500px] rounded-md bg-white p-4">
                                <h2 className="mb-4 text-2xl font-semibold">Actualizar Linea</h2>
                                <div className="flex flex-col gap-4">
                                    <label htmlFor="ordennn">Orden</label>
                                    <input
                                        className="focus:outline-primary-orange rounded-md p-2 outline outline-gray-300 focus:outline"
                                        type="text"
                                        name="ordennn"
                                        id="ordennn"
                                        value={updateForm?.data?.order}
                                        onChange={(e) => updateForm.setData('order', e.target.value)}
                                    />
                                    <label htmlFor="nombree">
                                        Nombre <span className="text-red-500">*</span>
                                    </label>
                                    <input
                                        className="focus:outline-primary-orange rounded-md p-2 outline outline-gray-300 focus:outline"
                                        type="text"
                                        name="nombree"
                                        id="nombree"
                                        value={updateForm?.data?.name}
                                        onChange={(e) => updateForm.setData('name', e.target.value)}
                                    />

                                    <label htmlFor="texto">Texto</label>
                                    <CustomReactQuill value={text} onChange={setText} />

                                    <label htmlFor="imagennn">Imagen</label>
                                    <input
                                        className="file:bg-primary-orange focus:outline-primary-orange rounded-md p-2 outline outline-gray-300 file:cursor-pointer file:rounded-sm file:px-2 file:py-1 file:text-white focus:outline"
                                        type="file"
                                        name="imagennn"
                                        id="imagennn"
                                        onChange={(e) => updateForm.setData('image', e.target.files[0])}
                                    />

                                    <div className="flex justify-end gap-4">
                                        <button
                                            type="button"
                                            onClick={() => setEdit(false)}
                                            className="border-primary-orange text-primary-orange hover:bg-primary-orange rounded-md border px-2 py-1 transition duration-300 hover:text-white"
                                        >
                                            Cancelar
                                        </button>
                                        <button
                                            type="submit"
                                            className="border-primary-orange text-primary-orange hover:bg-primary-orange rounded-md border px-2 py-1 transition duration-300 hover:text-white"
                                        >
                                            Actualizar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </motion.div>
                )}
            </AnimatePresence>
        </tr>
    );
}
