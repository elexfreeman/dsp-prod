
  Select 
  patient.lastName,patient.FirstName,patient.middleName,patient.BirthDate

  , Count(*) p_count 
  from [vaccination2].[dbo].[VACD_Patient]  patient

  
  Group by patient.FirstName,patient.lastName,patient.middleName,BirthDate
  
  having 
    --Count(*) > 1 and
     FirstName is not null
    and lastName is not null
    and middleName is not null
    and BirthDate is not null
    
    and FirstName <>''
    and lastName <>''
    and middleName <>''
order by Lastname
  