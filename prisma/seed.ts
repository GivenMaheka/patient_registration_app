import { PrismaClient } from '@prisma/client'

const prisma = new PrismaClient()

async function main(){

    const patient = await prisma.patients.create({
        data:{
            first_name: 'Given' ,
            last_name: 'Masheka' ,
            birth_date: new Date('1999-10-09') ,
            gender: 'Male'
        }
    })
}

main()
.then(async ()=>{
    await prisma.$disconnect()
})
.catch(async (e)=>{
    console.error(e)
    await prisma.$disconnect()
    process.exit(1)
})