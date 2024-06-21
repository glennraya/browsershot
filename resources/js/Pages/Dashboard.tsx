import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head, router } from '@inertiajs/react'
import { PageProps } from '@/types'
import {
    Table,
    TableHeader,
    TableColumn,
    TableBody,
    TableRow,
    TableCell,
    Button
} from '@nextui-org/react'

export default function Dashboard({ auth, products }: PageProps) {
    // Handle the simple pagination navigation.
    const handlePageChange = (url: string) => {
        if (url) {
            router.get(url)
        }
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="container mx-auto p-8 sm:px-6 lg:px-8 dark:text-white">
                <Table
                    isStriped
                    aria-label="Products table"
                    className="dark:dark"
                >
                    <TableHeader>
                        <TableColumn>NAME</TableColumn>
                        <TableColumn>QUANTITY</TableColumn>
                        <TableColumn>PRICE</TableColumn>
                        <TableColumn>STATUS</TableColumn>
                        <TableColumn>ACQUIRED AT</TableColumn>
                    </TableHeader>
                    <TableBody>
                        {products.data.map(product => (
                            <TableRow
                                key={product.id}
                                className={`${product.is_expired === 1 ? 'opacity-50' : ''}`}
                            >
                                <TableCell className="font-bold">
                                    {product.name}
                                </TableCell>
                                <TableCell>{product.quantity}</TableCell>
                                <TableCell>${product.price}</TableCell>
                                <TableCell>
                                    {product.is_expired === 1 ? 'Expired' : ''}
                                </TableCell>
                                <TableCell>{product.created_at}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
                {/* Pagination URL Links */}
                <div className="mt-2 flex justify-start gap-2">
                    <Button
                        className="bg-white font-medium text-black"
                        size="sm"
                        variant="faded"
                        color="primary"
                        isDisabled={!products.prev_page_url}
                        onPress={() => handlePageChange(products.prev_page_url)}
                    >
                        Previous
                    </Button>

                    <Button
                        className="bg-white font-medium text-black"
                        size="sm"
                        variant="faded"
                        color="primary"
                        isDisabled={!products.next_page_url}
                        onPress={() => handlePageChange(products.next_page_url)}
                    >
                        Next
                    </Button>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
