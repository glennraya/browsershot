import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { getLocalTimeZone, today } from '@internationalized/date'
import { Head, router } from '@inertiajs/react'
import { PageProps } from '@/types'
import {
    Table,
    TableHeader,
    TableColumn,
    TableBody,
    TableRow,
    TableCell,
    Button,
    DateRangePicker
} from '@nextui-org/react'
import { RangeValue } from '@react-types/shared'
import { DateValue } from '@react-types/datepicker'
import { useState } from 'react'

export default function Dashboard({ auth, products }: PageProps) {
    // Handle the simple pagination navigation.
    const handlePageChange = (url: string) => {
        if (url) {
            router.get(url)
        }
    }

    const [dateValue, setDateValue] = useState<RangeValue<DateValue>>({
        start: today(getLocalTimeZone()),
        end: today(getLocalTimeZone())
    })

    const [productsCopy, setProductsCopy] = useState(products)
    const generate = () => {
        router.post('filter', {
            start: dateValue.start.toDate(getLocalTimeZone()),
            end: dateValue.end.toDate(getLocalTimeZone())
        })
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
                <div className="mb-4 flex items-center gap-4">
                    <DateRangePicker
                        className="max-w-xs"
                        value={dateValue}
                        onChange={setDateValue}
                        variant="flat"
                    />
                    <Button
                        variant="flat"
                        color="default"
                        className="dark:text-white"
                        onClick={generate}
                    >
                        Generate
                    </Button>
                </div>

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
                        {productsCopy.data.map(product => (
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
                        className="font-medium dark:text-white"
                        size="sm"
                        variant="flat"
                        isDisabled={!products.prev_page_url}
                        onPress={() => handlePageChange(products.prev_page_url)}
                    >
                        Previous
                    </Button>

                    <Button
                        className="font-medium dark:text-white"
                        size="sm"
                        variant="flat"
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
